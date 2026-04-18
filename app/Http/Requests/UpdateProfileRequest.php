<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('members', 'email')->ignore(Auth::id()),
            ],
            'phone'   => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],

            'current_password' => ['nullable', 'required_with:password', 'current_password:web'],
            'password'         => ['nullable', 'confirmed', Password::min(8)],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.current_password' => 'Your current password is incorrect.',
            'current_password.required_with'    => 'Enter your current password to set a new one.',
        ];
    }
}
