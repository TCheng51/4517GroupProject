<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Requests\UpdateRoomStatusRequest;
use App\Mail\ReservationConfirmationMail;
use App\Models\MenuItem;
use App\Models\Member;
use App\Models\Reservation;
use App\Models\ReservationMenuItem;
use App\Models\Room;
use App\Models\TimeSlot;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MemberController extends Controller
{
    public function home(): \Illuminate\View\View
    {
        return view('home');
    }
    public function create(): \Illuminate\View\View
    {
        return view('auth.register');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:members,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $member = Member::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()->route('register.success')->with([
            'success' => 'Registration successful!',
            'member' => $member,
        ]);
    }

    public function confirmRegistration(): \Illuminate\View\View
    {
        return view('auth.register-confirm');
    }

    public function registerSuccess(): \Illuminate\View\View
    {
        $member = session('member');
        return view('auth.register-success', compact('member'));
    }

    public function showLoginForm(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('reservation');
        }

        return back()->withErrors([
            'email' => 'Your dice roll failed! Try again.',
        ])->onlyInput('email');
    }

    public function showReservation(): \Illuminate\View\View
    {
        return view('reservation', [
            'isAuthenticated' => Auth::check(),
            'rooms' => Room::active()->orderBy('sort_order')->get(),
            'timeSlots' => TimeSlot::active()->orderBy('sort_order')->get(),
            'menuItemsByCategory' => MenuItem::active()
                ->orderBy('sort_order')
                ->get()
                ->groupBy('category'),
        ]);
    }

    public function confirmReservation(): \Illuminate\View\View
    {
        return view('reservation-confirm');
    }

    public function makeReservation(ReservationRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $room = Room::active()->where('slug', $validated['table_room'])->firstOrFail();
        $timeSlot = TimeSlot::active()->where('label', $validated['time_slot'])->firstOrFail();

        try {
            $reservation = DB::transaction(function () use ($validated, $room, $timeSlot) {
                if ($this->availableSpots($room, $timeSlot, $validated['reservation_date']) <= 0) {
                    abort(409, 'slot-full');
                }

                $reservation = Reservation::create([
                    'member_id' => Auth::id(),
                    'room_id' => $room->id,
                    'time_slot_id' => $timeSlot->id,
                    'reservation_date' => $validated['reservation_date'],
                    'time_slot' => $timeSlot->label,
                    'table_room' => $room->slug,
                    'status' => 'pending',
                    'confirmation_code' => $this->makeConfirmationCode(),
                    'is_guest' => ! Auth::check(),
                    'guest_name' => $validated['guest_name'] ?? null,
                    'guest_email' => $validated['guest_email'] ?? null,
                    'guest_phone' => $validated['guest_phone'] ?? null,
                ]);

                $this->storeReservationMenuItems($reservation, $validated['menu_items'] ?? []);

                return $reservation->load(['member', 'room', 'timeSlot', 'reservationMenuItems.menuItem']);
            });
        } catch (HttpException $e) {
            if ($e->getMessage() === 'slot-full') {
                return back()
                    ->withErrors(['table_room' => 'That room and time slot are fully booked. Please pick another.'])
                    ->withInput();
            }

            throw $e;
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'reservations_member_slot_unique')
                || str_contains($e->getMessage(), 'UNIQUE constraint failed')) {
                return back()
                    ->withErrors(['table_room' => 'You already have a reservation for that room and time.'])
                    ->withInput();
            }

            throw $e;
        }

        $this->sendReservationMail($reservation, 'created');

        return redirect()->route('reservation.success')->with([
            'success' => 'Reservation successful!',
            'reservation_id' => $reservation->id,
            'email_simulated' => 'Reservation confirmation email simulated for ' . $reservation->customer_email . '.',
        ]);
    }

    public function reservationSuccess(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        $reservationId = session('reservation_id') ?? session('reservation')?->id;

        if (! $reservationId) {
            return redirect()->route('reservation');
        }

        $reservation = Reservation::with(['member', 'room', 'timeSlot', 'reservationMenuItems.menuItem'])
            ->findOrFail($reservationId);

        return view('reservation-success', compact('reservation'));
    }

    public function availability(Request $request): JsonResponse
    {
        $date = $request->query('reservation_date');
        $room = Room::active()->where('slug', $request->query('table_room'))->first();
        $timeSlot = TimeSlot::active()->where('label', $request->query('time_slot'))->first();

        if (! $date || ! $room || ! $timeSlot) {
            return response()->json([
                'available' => false,
                'message' => 'Choose a date, time slot, and room to check availability.',
            ], 422);
        }

        try {
            $reservationDate = Carbon::parse($date)->toDateString();
        } catch (\Throwable) {
            return response()->json([
                'available' => false,
                'message' => 'Choose a valid reservation date.',
            ], 422);
        }

        if (Carbon::parse($reservationDate)->lessThanOrEqualTo(today())) {
            return response()->json([
                'available' => false,
                'message' => 'Reservations must be placed for a future date.',
            ], 422);
        }

        $availableSpots = $this->availableSpots($room, $timeSlot, $reservationDate);

        return response()->json([
            'available' => $availableSpots > 0,
            'available_spots' => $availableSpots,
            'capacity' => $room->capacity,
            'message' => $availableSpots > 0
                ? $availableSpots . ' spots available.'
                : 'That room and time slot are fully booked.',
        ]);
    }

    public function showMenu(): \Illuminate\View\View
    {
        return view('menu', [
            'menuItemsByCategory' => MenuItem::active()
                ->orderBy('sort_order')
                ->get()
                ->groupBy('category'),
        ]);
    }

    public function myReservations(): \Illuminate\View\View
    {
        $reservations = Auth::user()
            ->reservations()
            ->with(['room', 'timeSlot', 'reservationMenuItems.menuItem'])
            ->orderByDesc('reservation_date')
            ->orderByDesc('id')
            ->simplePaginate(10);

        return view('my-reservations', compact('reservations'));
    }

    public function editReservation(Reservation $reservation): \Illuminate\View\View
    {
        $this->authorizeMemberReservation($reservation);
        $this->ensureEditableReservation($reservation);

        return view('reservation-edit', [
            'reservation' => $reservation->load(['room', 'timeSlot', 'reservationMenuItems.menuItem']),
            'rooms' => Room::active()->orderBy('sort_order')->get(),
            'timeSlots' => TimeSlot::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function updateReservation(UpdateReservationRequest $request, Reservation $reservation): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeMemberReservation($reservation);
        $this->ensureEditableReservation($reservation);

        $validated = $request->validated();
        $room = Room::active()->where('slug', $validated['table_room'])->firstOrFail();
        $timeSlot = TimeSlot::active()->where('label', $validated['time_slot'])->firstOrFail();

        try {
            DB::transaction(function () use ($reservation, $validated, $room, $timeSlot) {
                if ($this->availableSpots($room, $timeSlot, $validated['reservation_date'], $reservation->id) <= 0) {
                    abort(409, 'slot-full');
                }

                $reservation->update([
                    'room_id' => $room->id,
                    'time_slot_id' => $timeSlot->id,
                    'reservation_date' => $validated['reservation_date'],
                    'time_slot' => $timeSlot->label,
                    'table_room' => $room->slug,
                    'status' => 'pending',
                    'confirmed_at' => null,
                    'cancelled_at' => null,
                ]);
            });
        } catch (HttpException $e) {
            if ($e->getMessage() === 'slot-full') {
                return back()
                    ->withErrors(['table_room' => 'That room and time slot are fully booked. Please pick another.'])
                    ->withInput();
            }

            throw $e;
        }

        $reservation->refresh()->load(['member', 'room', 'timeSlot', 'reservationMenuItems.menuItem']);
        $this->sendReservationMail($reservation, 'updated');

        return redirect()
            ->route('my-reservations')
            ->with('success', 'Reservation updated. Confirmation email simulated for ' . $reservation->customer_email . '.');
    }

    public function cancelReservation(Reservation $reservation): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeMemberReservation($reservation);
        $this->ensureEditableReservation($reservation);

        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $reservation->load(['member', 'room', 'timeSlot', 'reservationMenuItems.menuItem']);
        $this->sendReservationMail($reservation, 'cancelled');

        return redirect()
            ->route('my-reservations')
            ->with('success', 'Reservation cancelled. Confirmation email simulated for ' . $reservation->customer_email . '.');
    }

    public function showRoomStatus(Request $request): \Illuminate\View\View
    {
        $rooms = Room::active()->orderBy('sort_order')->get();
        $timeSlots = TimeSlot::active()->orderBy('sort_order')->get();
        $selectedDate = $this->selectedStatusDate($request->query('date'));
        $selectedRoom = $request->query('room');
        $selectedStatus = $request->query('status');

        if (! $rooms->contains('slug', $selectedRoom)) {
            $selectedRoom = null;
        }

        if (! in_array($selectedStatus, ['pending', 'confirmed', 'cancelled'], true)) {
            $selectedStatus = null;
        }

        $bookedCounts = Reservation::query()
            ->whereDate('reservation_date', $selectedDate)
            ->where('status', '!=', 'cancelled')
            ->selectRaw('room_id, time_slot_id, table_room, time_slot, COUNT(*) as booked')
            ->groupBy('room_id', 'time_slot_id', 'table_room', 'time_slot')
            ->get();

        $roomAvailability = [];
        foreach ($rooms as $room) {
            $roomAvailability[$room->slug] = [];

            foreach ($timeSlots as $timeSlot) {
                $booked = $bookedCounts
                    ->filter(fn ($count) => (
                        ((int) $count->room_id === (int) $room->id && (int) $count->time_slot_id === (int) $timeSlot->id)
                        || ($count->table_room === $room->slug && $count->time_slot === $timeSlot->label)
                    ))
                    ->sum('booked');

                $roomAvailability[$room->slug][$timeSlot->label] = max(0, $room->capacity - (int) $booked);
            }
        }

        $baseQuery = Reservation::with(['member', 'room', 'timeSlot', 'reservationMenuItems.menuItem'])
            ->whereDate('reservation_date', $selectedDate)
            ->when($selectedRoom, fn ($query) => $query->where(function ($query) use ($selectedRoom) {
                $query->whereHas('room', fn ($roomQuery) => $roomQuery->where('slug', $selectedRoom))
                    ->orWhere('table_room', $selectedRoom);
            }));

        $totalReservations = (clone $baseQuery)->count();
        $pendingReservations = (clone $baseQuery)->where('status', 'pending')->count();
        $confirmedReservations = (clone $baseQuery)->where('status', 'confirmed')->count();

        $todayReservations = $baseQuery
            ->when($selectedStatus, fn ($query) => $query->where('status', $selectedStatus))
            ->orderBy('time_slot')
            ->orderBy('table_room')
            ->simplePaginate(50)
            ->withQueryString();

        $availableRooms = 0;
        foreach ($roomAvailability as $roomSlots) {
            foreach ($roomSlots as $available) {
                if ($available > 0) {
                    $availableRooms++;
                    break;
                }
            }
        }

        return view('room-status', compact(
            'rooms',
            'timeSlots',
            'todayReservations',
            'roomAvailability',
            'totalReservations',
            'pendingReservations',
            'confirmedReservations',
            'availableRooms',
            'selectedDate',
            'selectedRoom',
            'selectedStatus'
        ));
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function availableSpots(Room $room, TimeSlot $timeSlot, string $date, ?int $excludeReservationId = null): int
    {
        $booked = Reservation::query()
            ->whereDate('reservation_date', $date)
            ->where('status', '!=', 'cancelled')
            ->when($excludeReservationId, fn ($query) => $query->whereKeyNot($excludeReservationId))
            ->where(function ($query) use ($room, $timeSlot) {
                $query->where(function ($query) use ($room, $timeSlot) {
                    $query->where('room_id', $room->id)
                        ->where('time_slot_id', $timeSlot->id);
                })->orWhere(function ($query) use ($room, $timeSlot) {
                    $query->where('table_room', $room->slug)
                        ->where('time_slot', $timeSlot->label);
                });
            })
            ->lockForUpdate()
            ->count();

        return max(0, $room->capacity - $booked);
    }

    private function storeReservationMenuItems(Reservation $reservation, array $menuItems): void
    {
        $quantities = collect($menuItems)
            ->map(fn ($quantity) => (int) $quantity)
            ->filter(fn ($quantity) => $quantity > 0);

        if ($quantities->isEmpty()) {
            return;
        }

        $items = MenuItem::active()
            ->whereIn('id', $quantities->keys()->all())
            ->get()
            ->keyBy('id');

        foreach ($quantities as $menuItemId => $quantity) {
            $menuItem = $items->get((int) $menuItemId);

            if (! $menuItem) {
                continue;
            }

            ReservationMenuItem::create([
                'reservation_id' => $reservation->id,
                'menu_item_id' => $menuItem->id,
                'quantity' => $quantity,
                'unit_price' => $menuItem->price,
                'line_total' => (float) $menuItem->price * $quantity,
            ]);
        }
    }

    private function makeConfirmationCode(): string
    {
        do {
            $code = 'FB' . now()->format('ymd') . Str::upper(Str::random(4));
        } while (Reservation::where('confirmation_code', $code)->exists());

        return $code;
    }

    private function sendReservationMail(Reservation $reservation, string $action): void
    {
        if (! $reservation->customer_email) {
            return;
        }

        Mail::to($reservation->customer_email)->send(new ReservationConfirmationMail($reservation, $action));
    }

    private function authorizeMemberReservation(Reservation $reservation): void
    {
        abort_unless(Auth::check() && (int) $reservation->member_id === (int) Auth::id(), 403);
    }

    private function ensureEditableReservation(Reservation $reservation): void
    {
        abort_if($reservation->status === 'cancelled' || ! $reservation->isUpcoming(), 403);
    }

    private function selectedStatusDate(?string $date): string
    {
        if (! $date) {
            return today()->toDateString();
        }

        try {
            return Carbon::parse($date)->toDateString();
        } catch (\Throwable) {
            return today()->toDateString();
        }
    }
}
