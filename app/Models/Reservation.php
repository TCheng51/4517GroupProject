<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'reservation_date',
        'time_slot',
        'table_room',
        'status',
        'guest_name',
        'guest_email',
        'guest_phone',
        'is_guest',
    ];

    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
            'is_guest' => 'boolean',
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the customer name (guest name or member full name)
     */
    public function getCustomerNameAttribute(): string
    {
        if ($this->is_guest) {
            return $this->guest_name ?? 'Guest';
        }
        return $this->member ? $this->member->first_name . ' ' . $this->member->last_name : 'Unknown';
    }

    /**
     * Get the customer email (guest email or member email)
     */
    public function getCustomerEmailAttribute(): ?string
    {
        if ($this->is_guest) {
            return $this->guest_email;
        }
        return $this->member?->email;
    }

    /**
     * Get the customer phone (guest phone or member phone)
     */
    public function getCustomerPhoneAttribute(): ?string
    {
        if ($this->is_guest) {
            return $this->guest_phone;
        }
        return $this->member?->phone;
    }

    /**
     * Scope for guest reservations
     */
    public function scopeGuests($query)
    {
        return $query->where('is_guest', true);
    }

    /**
     * Scope for member reservations
     */
    public function scopeMembers($query)
    {
        return $query->where('is_guest', false)->orWhereNull('is_guest');
    }
}
