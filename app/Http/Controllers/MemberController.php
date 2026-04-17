<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateRoomStatusRequest;
use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

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

        // member_number is set by Member's `created` hook; password is hashed by the cast.
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
        ]);
    }

    public function confirmReservation(): \Illuminate\View\View
    {
        return view('reservation-confirm');
    }

    public function makeReservation(ReservationRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $themes = config('rooms.themes');
        $room = $validated['table_room'];

        if (! isset($themes[$room])) {
            return back()
                ->withErrors(['table_room' => 'That room is no longer available.'])
                ->withInput();
        }

        $capacity = (int) $themes[$room]['capacity'];

        // Atomic: count + insert must not race with another booking. The unique
        // index on (member_id, date, time_slot, table_room) prevents members from
        // double-booking even if this check races; guests rely on the count alone.
        try {
            $reservation = DB::transaction(function () use ($validated, $room, $capacity) {
                $booked = Reservation::query()
                    ->where('reservation_date', $validated['reservation_date'])
                    ->where('time_slot', $validated['time_slot'])
                    ->where('table_room', $room)
                    ->where('status', '!=', 'cancelled')
                    ->lockForUpdate()
                    ->count();

                if ($booked >= $capacity) {
                    abort(409, 'slot-full');
                }

                $isGuest = ! Auth::check();

                return Reservation::create([
                    'member_id' => Auth::id(),
                    'reservation_date' => $validated['reservation_date'],
                    'time_slot' => $validated['time_slot'],
                    'table_room' => $room,
                    'status' => 'pending',
                    'is_guest' => $isGuest,
                    'guest_name' => $validated['guest_name'] ?? null,
                    'guest_email' => $validated['guest_email'] ?? null,
                    'guest_phone' => $validated['guest_phone'] ?? null,
                ]);
            });
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            if ($e->getMessage() === 'slot-full') {
                return back()
                    ->withErrors(['table_room' => 'That room and time slot are fully booked. Please pick another.'])
                    ->withInput();
            }
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            // Unique index violation — member already booked this exact slot.
            if (str_contains($e->getMessage(), 'reservations_member_slot_unique')
                || str_contains($e->getMessage(), 'UNIQUE constraint failed')) {
                return back()
                    ->withErrors(['table_room' => 'You already have a reservation for that room and time.'])
                    ->withInput();
            }
            throw $e;
        }

        return redirect()->route('reservation.success')->with([
            'success' => 'Reservation successful!',
            'reservation' => $reservation,
        ]);
    }

    public function reservationSuccess(): \Illuminate\View\View
    {
        $reservation = session('reservation');
        return view('reservation-success', compact('reservation'));
    }

    public function showMenu(): \Illuminate\View\View
    {
        return view('menu');
    }

    public function showRoomStatus(): \Illuminate\View\View
    {
        $roomThemes = config('rooms.themes');
        $timeSlots = config('rooms.time_slots');

        // Single GROUP BY query counts active bookings per (room, slot) for today.
        // Replaces the previous "load all rows, filter in PHP" pattern.
        $bookedCounts = Reservation::query()
            ->whereDate('reservation_date', today())
            ->where('status', '!=', 'cancelled')
            ->selectRaw('table_room, time_slot, COUNT(*) as booked')
            ->groupBy('table_room', 'time_slot')
            ->get()
            ->keyBy(fn ($r) => $r->table_room . '|' . $r->time_slot);

        $roomAvailability = [];
        foreach ($roomThemes as $roomKey => $roomInfo) {
            $roomAvailability[$roomKey] = [];
            foreach ($timeSlots as $slot) {
                $booked = (int) ($bookedCounts[$roomKey . '|' . $slot]->booked ?? 0);
                $roomAvailability[$roomKey][$slot] = max(0, (int) $roomInfo['capacity'] - $booked);
            }
        }

        // Paginated list of today's reservations for the admin table.
        $todayReservations = Reservation::with('member')
            ->whereDate('reservation_date', today())
            ->orderBy('time_slot')
            ->orderBy('table_room')
            ->simplePaginate(50)
            ->through(fn ($r) => $r);

        // Aggregate status counts in one query instead of collection filtering.
        $statusCounts = Reservation::query()
            ->whereDate('reservation_date', today())
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed
            ")
            ->first();

        $totalReservations = (int) ($statusCounts->total ?? 0);
        $pendingReservations = (int) ($statusCounts->pending ?? 0);
        $confirmedReservations = (int) ($statusCounts->confirmed ?? 0);

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
            'roomThemes',
            'timeSlots',
            'todayReservations',
            'roomAvailability',
            'totalReservations',
            'pendingReservations',
            'confirmedReservations',
            'availableRooms'
        ));
    }

    public function updateRoomStatus(UpdateRoomStatusRequest $request, Reservation $reservation): \Illuminate\Http\RedirectResponse
    {
        $reservation->update(['status' => $request->validated()['status']]);

        return redirect()->route('room-status')->with('success', 'Reservation status updated successfully!');
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
