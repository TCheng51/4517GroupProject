<?php

namespace App\Http\Requests;

use App\Models\MenuItem;
use App\Models\Room;
use App\Models\TimeSlot;
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
        $roomSlugs = Room::active()->pluck('slug')->all();
        $slotLabels = TimeSlot::active()->pluck('label')->all();

        $rules = [
            'reservation_date' => ['required', 'date', 'after:today'],
            'time_slot' => ['required', 'string', Rule::in($slotLabels)],
            'table_room' => ['required', 'string', Rule::in($roomSlugs)],
            'menu_items' => ['nullable', 'array'],
            'menu_items.*' => ['nullable', 'integer', 'min:0', 'max:9'],
        ];

        if (! Auth::check()) {
            $rules['guest_name'] = ['required', 'string', 'max:255'];
            $rules['guest_email'] = ['required', 'email', 'max:255'];
            $rules['guest_phone'] = ['required', 'string', 'max:20'];
        }

        return $rules;
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $menuItems = $this->input('menu_items', []);

            if (! is_array($menuItems)) {
                return;
            }

            $activeIds = MenuItem::active()->pluck('id')->map(fn ($id) => (string) $id)->all();

            foreach (array_keys($menuItems) as $id) {
                if (! in_array((string) $id, $activeIds, true)) {
                    $validator->errors()->add('menu_items', 'One selected menu item is no longer available.');
                    return;
                }
            }
        });
    }
}
