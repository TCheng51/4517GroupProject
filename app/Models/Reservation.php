<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'reservation_date',
        'time_slot',
        'table_room',
        'status',
        'number_of_guests',
        'total_amount',
        'payment_status',
        'special_requests',
        'notes',
        'confirmed_at',
        'cancelled_at',
        'confirmation_code',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
