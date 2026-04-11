<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Show the registration confirmation page
     */
    public function showConfirmationForm()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }

        return view('auth.register-confirm');
    }

    /**
     * Process registration form and show confirmation
     */
    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Store registration data in session for confirmation
        Session::put('registration_data', $request->except(['password_confirmation']));

        return redirect()->route('register.confirm');
    }

    /**
     * Confirm and complete registration
     */
    public function confirmRegistration(Request $request)
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }

        $data = Session::get('registration_data');

        try {
            // Create the member
            $member = Member::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'password' => Hash::make($data['password']),
            ]);

            // Clear registration data from session
            Session::forget('registration_data');

            // Store member info for success page
            Session::flash('member_info', [
                'member_number' => $member->member_number,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'email' => $member->email,
            ]);

            return redirect()->route('register.success', ['member' => $member]);

        } catch (\Exception $e) {
            // Log error
            Log::error('Registration failed: ' . $e->getMessage());

            return redirect()->route('register')
                        ->with('error', 'Registration failed. Please try again.')
                        ->withInput();
        }
    }

    /**
     * Show the registration success page
     */
    public function showSuccessPage()
    {
        if (!Session::has('member_info')) {
            return redirect()->route('login');
        }

        $memberInfo = Session::get('member_info');
        
        // Create a member object for the view
        $member = (object) $memberInfo;

        return view('auth.register-success', compact('member'));
    }

    /**
     * Handle AJAX registration (for API usage)
     */
    public function ajaxRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $member = Member::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful!',
                'member' => [
                    'id' => $member->id,
                    'member_number' => $member->member_number,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'email' => $member->email,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('AJAX Registration failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Check if email is available (for real-time validation)
     */
    public function checkEmailAvailability(Request $request)
    {
        $email = $request->input('email');
        $exists = Member::where('email', $email)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Email is already taken' : 'Email is available'
        ]);
    }

    /**
     * Validate registration form (for real-time validation)
     */
    public function validateRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'errors' => $validator->errors()
            ]);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Form is valid'
        ]);
    }
}
