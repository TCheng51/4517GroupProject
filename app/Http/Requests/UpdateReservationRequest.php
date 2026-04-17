<?php

namespace App\Http\Requests;

use App\Models\Room;
use App\Models\TimeSlot;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $reservation = $this->route('reservation');

        return $this->user()
            && $reservation
            && (int) $reservation->member_id === (int) $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'reservation_date' => ['required', 'date', 'after:today'],
            'time_slot' => ['required', 'string', Rule::in(TimeSlot::active()->pluck('label')->all())],
            'table_room' => ['required', 'string', Rule::in(Room::active()->pluck('slug')->all())],
        ];
    }
}
