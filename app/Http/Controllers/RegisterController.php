<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckEmailRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function showRegistrationForm(): \Illuminate\View\View
    {
        return view('auth.register');
    }

    public function showConfirmationForm(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (! Session::has('registration_data')) {
            return redirect()->route('register');
        }

        $registrationData = Session::get('registration_data');
        // Never expose the (hashed) password to the confirmation view.
        unset($registrationData['password']);

        return view('auth.register-confirm', compact('registrationData'));
    }

    public function processRegistration(RegisterRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Hash the password now so the plaintext never touches the session store.
        $data = $request->safe()->except(['password', 'password_confirmation']);
        $data['password'] = Hash::make($request->input('password'));
        Session::put('registration_data', $data);

        return redirect()->route('register.confirm');
    }

    public function confirmRegistration(): \Illuminate\Http\RedirectResponse
    {
        if (! Session::has('registration_data')) {
            return redirect()->route('register');
        }

        $data = Session::get('registration_data');

        try {
            // Password is already hashed (see processRegistration). The Member
            // model's `hashed` cast is idempotent, so this passes through safely.
            $member = Member::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'password' => $data['password'],
            ]);

            Session::forget('registration_data');

            Session::flash('member_info', [
                'member_number' => $member->member_number,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'email' => $member->email,
            ]);

            return redirect()->route('register.success');
        } catch (\Throwable $e) {
            Log::error('Registration failed', ['exception' => $e]);

            return redirect()->route('register')
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }

    public function showSuccessPage(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (! Session::has('member_info')) {
            return redirect()->route('login');
        }

        $member = (object) Session::get('member_info');

        return view('auth.register-success', compact('member'));
    }

    public function ajaxRegister(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Password hashed by the Member model's cast.
            $member = Member::create($request->safe()->except(['password_confirmation']));

            return response()->json([
                'success' => true,
                'message' => 'Registration successful!',
                'member' => [
                    'id' => $member->id,
                    'member_number' => $member->member_number,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'email' => $member->email,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('AJAX Registration failed', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
            ], 500);
        }
    }

    public function checkEmailAvailability(CheckEmailRequest $request): \Illuminate\Http\JsonResponse
    {
        $email = $request->validated()['email'];
        $exists = Member::where('email', $email)->exists();

        return response()->json([
            'available' => ! $exists,
            'message' => $exists ? 'Email is already taken' : 'Email is available',
        ]);
    }

    public function validateRegistration(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        // If we reach this method the FormRequest has already validated.
        return response()->json([
            'valid' => true,
            'message' => 'Form is valid',
        ]);
    }
}
