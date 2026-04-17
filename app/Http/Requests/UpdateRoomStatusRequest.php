<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route is already protected by the `admin` middleware; this is a
        // defence-in-depth check that survives route refactors.
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:confirmed,cancelled'],
        ];
    }
}
