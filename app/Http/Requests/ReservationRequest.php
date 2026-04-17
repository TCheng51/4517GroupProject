<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $themeKeys = array_keys(config('rooms.themes', []));
        $slotOptions = config('rooms.time_slots', []);

        $rules = [
            'reservation_date' => ['required', 'date', 'after:today'],
            'time_slot' => ['required', 'string', Rule::in($slotOptions)],
            'table_room' => ['required', 'string', Rule::in($themeKeys)],
        ];

        if (! Auth::check()) {
            $rules['guest_name'] = ['required', 'string', 'max:255'];
            $rules['guest_email'] = ['required', 'email', 'max:255'];
            $rules['guest_phone'] = ['required', 'string', 'max:20'];
        }

        return $rules;
    }
}
