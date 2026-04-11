<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            if (empty($member->member_number)) {
                $lastMember = Member::orderBy('id', 'desc')->first();
                $lastNumber = $lastMember ? (int)$lastMember->member_number : 0;
                $member->member_number = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    protected $fillable = [
        'member_number',
        'first_name',
        'last_name', 
        'email',
        'phone',
        'address',
        'password',
        'date_of_birth',
        'gender',
        'membership_type',
        'membership_expiry',
        'is_active',
        'notes',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
