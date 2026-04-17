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

<<<<<<< HEAD
        static::creating(function ($member) {
            if (empty($member->member_number)) {
                $lastMember = Member::orderBy('id', 'desc')->first();
                $lastNumber = $lastMember ? (int)$lastMember->member_number : 0;
                $member->member_number = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
=======
        // Derive member_number from the row's primary key AFTER insert so the value
        // is race-free (DB auto-increments `id` atomically). Manual member_number
        // values set by seeders/controllers are preserved.
        static::created(function ($member) {
            if (empty($member->member_number)) {
                $member->member_number = str_pad((string) $member->id, 4, '0', STR_PAD_LEFT);
                $member->saveQuietly();
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
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
<<<<<<< HEAD
        'date_of_birth',
        'gender',
        'membership_type',
        'membership_expiry',
        'is_active',
        'notes',
        'profile_picture',
=======
        'is_admin',
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
