<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'room_id',
        'time_slot_id',
        'reservation_date',
        'time_slot',
        'table_room',
        'status',
        'confirmation_code',
        'confirmed_at',
        'cancelled_at',
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
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function reservationMenuItems(): HasMany
    {
        return $this->hasMany(ReservationMenuItem::class);
    }

    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'reservation_menu_items')
            ->withPivot(['quantity', 'unit_price', 'line_total'])
            ->withTimestamps();
    }

    public function getRoomNameAttribute(): string
    {
        return $this->room?->name ?? $this->table_room ?? 'Unknown room';
    }

    public function getTimeSlotLabelAttribute(): string
    {
        return $this->timeSlot?->label ?? $this->time_slot ?? 'Unknown time';
    }

    public function getMenuTotalAttribute(): float
    {
        return (float) $this->reservationMenuItems->sum('line_total');
    }

    public function isUpcoming(): bool
    {
        return $this->reservation_date?->isFuture() || $this->reservation_date?->isToday();
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
