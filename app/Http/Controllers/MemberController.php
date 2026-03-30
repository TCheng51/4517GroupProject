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

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
