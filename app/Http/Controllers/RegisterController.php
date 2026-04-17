<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
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
=======
use App\Http\Requests\CheckEmailRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\RegistrationConfirmationMail;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
    public function showRegistrationForm(): \Illuminate\View\View
    {
        return view('auth.register');
    }

<<<<<<< HEAD
    /**
     * Show the registration confirmation page
     */
    public function showConfirmationForm(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (!Session::has('registration_data')) {
=======
    public function showConfirmationForm(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (! Session::has('registration_data')) {
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
            return redirect()->route('register');
        }

        $registrationData = Session::get('registration_data');
<<<<<<< HEAD
=======
        // Never expose the (hashed) password to the confirmation view.
        unset($registrationData['password']);
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb

        return view('auth.register-confirm', compact('registrationData'));
    }

<<<<<<< HEAD
    /**
     * Process registration form and show confirmation
     */
    public function processRegistration(Request $request): \Illuminate\Http\RedirectResponse
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
=======
    public function processRegistration(RegisterRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Hash the password now so the plaintext never touches the session store.
        $data = $request->safe()->except(['password', 'password_confirmation']);
        $data['password'] = Hash::make($request->input('password'));
        Session::put('registration_data', $data);
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb

        return redirect()->route('register.confirm');
    }

<<<<<<< HEAD
    /**
     * Confirm and complete registration
     */
    public function confirmRegistration(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (!Session::has('registration_data')) {
=======
    public function confirmRegistration(): \Illuminate\Http\RedirectResponse
    {
        if (! Session::has('registration_data')) {
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
            return redirect()->route('register');
        }

        $data = Session::get('registration_data');

        try {
<<<<<<< HEAD
            // Create the member
=======
            // Password is already hashed (see processRegistration). The Member
            // model's `hashed` cast is idempotent, so this passes through safely.
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
            $member = Member::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
<<<<<<< HEAD
                'password' => Hash::make($data['password']),
            ]);

            // Clear registration data from session
            Session::forget('registration_data');

            // Store member info for success page
=======
                'password' => $data['password'],
            ]);

            Session::forget('registration_data');

>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
            Session::flash('member_info', [
                'member_number' => $member->member_number,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'email' => $member->email,
            ]);
<<<<<<< HEAD

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
    public function showSuccessPage(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (!Session::has('member_info')) {
            return redirect()->route('login');
        }

        $memberInfo = Session::get('member_info');

        // Create a member object for the view
        $member = (object) $memberInfo;
=======
            Session::flash('email_simulated', 'Membership confirmation email simulated for ' . $member->email . '.');

            Mail::to($member->email)->send(new RegistrationConfirmationMail($member));

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
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb

        return view('auth.register-success', compact('member'));
    }

<<<<<<< HEAD
    /**
     * Handle AJAX registration (for API usage)
     */
    public function ajaxRegister(Request $request): \Illuminate\Http\JsonResponse
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
=======
    public function ajaxRegister(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Password hashed by the Member model's cast.
            $member = Member::create($request->safe()->except(['password_confirmation']));
            Mail::to($member->email)->send(new RegistrationConfirmationMail($member));

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Confirmation email simulated.',
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
                'member' => [
                    'id' => $member->id,
                    'member_number' => $member->member_number,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'email' => $member->email,
<<<<<<< HEAD
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('AJAX Registration failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
=======
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('AJAX Registration failed', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
            ], 500);
        }
    }

<<<<<<< HEAD
    /**
     * Check if email is available (for real-time validation)
     */
    public function checkEmailAvailability(Request $request): \Illuminate\Http\JsonResponse
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
    public function validateRegistration(Request $request): \Illuminate\Http\JsonResponse
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
=======
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
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
        ]);
    }
}
