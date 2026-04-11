<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MemberController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function home()
    {
        return view('home');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:members,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Generate 4-digit member number
        $memberNumber = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);

        $member = Member::create([
            'member_number' => $memberNumber,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('register.success')->with([
            'success' => 'Registration successful!',
            'member' => $member
        ]);
    }

    public function confirmRegistration()
    {
        return view('auth.register-confirm');
    }

    public function registerSuccess()
    {
        $member = session('member');
        return view('auth.register-success', compact('member'));
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('reservation');
        }

        return back()->withErrors([
            'email' => 'Your dice roll failed! Try again.',
        ])->onlyInput('email');
    }

    public function showReservation()
    {
        return view('reservation');
    }

    public function confirmReservation()
    {
        return view('reservation-confirm');
    }

    public function makeReservation(Request $request)
    {
        $validated = $request->validate([
            'reservation_date' => 'required|date|after:today',
            'time_slot' => 'required|string',
            'table_room' => 'required|string',
        ]);

        $reservation = Reservation::create([
            'member_id' => Auth::id(),
            'reservation_date' => $validated['reservation_date'],
            'time_slot' => $validated['time_slot'],
            'table_room' => $validated['table_room'],
            'status' => 'pending',
        ]);

        return redirect()->route('reservation.success')->with([
            'success' => 'Reservation successful!',
            'reservation' => $reservation
        ]);
    }

    public function reservationSuccess()
    {
        $reservation = session('reservation');
        return view('reservation-success', compact('reservation'));
    }

    public function showMenu()
    {
        return view('menu');
    }

    public function showRoomStatus()
    {
        // Define room themes with their information
        $roomThemes = [
            'fantasy-hearth' => [
                'name' => 'Fantasy Hearth',
                'capacity' => 4,
                'description' => 'A cozy medieval tavern setting with warm lighting, wooden tables, and fantasy decor perfect for RPG sessions.'
            ],
            'mythic-garden' => [
                'name' => 'Mythic Garden',
                'capacity' => 4,
                'description' => 'An enchanted forest atmosphere with lush greenery, natural elements, and mystical ambiance.'
            ],
            'iron-archive' => [
                'name' => 'Iron Archive',
                'capacity' => 4,
                'description' => 'A steampunk library setting with metal accents, gears, and Victorian-inspired decor.'
            ],
            'starlight-orbit' => [
                'name' => 'Starlight Orbit',
                'capacity' => 6,
                'description' => 'A futuristic space station theme with cosmic lighting and sci-fi elements.'
            ],
            'clockwork-vault' => [
                'name' => 'Clockwork Vault',
                'capacity' => 6,
                'description' => 'A mysterious mechanical chamber with intricate clockwork mechanisms and puzzle-solving atmosphere.'
            ],
            'storykeeper-suite' => [
                'name' => 'Storykeeper Suite',
                'capacity' => 8,
                'description' => 'A grand literary salon with bookshelves, comfortable seating, and storytelling ambiance.'
            ]
        ];

        $timeSlots = ['2:00-4:00', '6:00-9:00', '9:00-11:00'];

        // Get today's reservations grouped by room
        $todayReservations = Reservation::with('member')
            ->whereDate('reservation_date', today())
            ->get()
            ->groupBy('table_room');

        // Calculate room availability
        $roomAvailability = [];
        foreach ($roomThemes as $roomTheme => $roomInfo) {
            $roomAvailability[$roomTheme] = [];
            foreach ($timeSlots as $slot) {
                $reservationsInSlot = $todayReservations->get($roomTheme, collect())
                    ->where('time_slot', $slot)
                    ->where('status', '!=', 'cancelled')
                    ->count();
                
                // Calculate available spots based on room capacity
                $maxCapacity = $roomInfo['capacity'];
                $roomAvailability[$roomTheme][$slot] = max(0, $maxCapacity - $reservationsInSlot);
            }
        }

        // Calculate statistics
        $totalReservations = $todayReservations->flatten()->count();
        $pendingReservations = $todayReservations->flatten()->where('status', 'pending')->count();
        $confirmedReservations = $todayReservations->flatten()->where('status', 'confirmed')->count();
        
        // Count available rooms (rooms with at least one available slot)
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

    public function updateRoomStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled'
        ]);

        $reservation->update(['status' => $validated['status']]);

        return redirect()->route('room-status')->with('success', 'Reservation status updated successfully!');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
