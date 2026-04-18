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

        // Derive member_number from the row's primary key AFTER insert so the value
        // is race-free (DB auto-increments `id` atomically). Manual member_number
        // values set by seeders/controllers are preserved.
        static::created(function ($member) {
            if (empty($member->member_number)) {
                $member->member_number = str_pad((string) $member->id, 4, '0', STR_PAD_LEFT);
                $member->saveQuietly();
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
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
