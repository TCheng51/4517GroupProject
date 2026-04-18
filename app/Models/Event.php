<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'room_id',
        'max_participants',
        'entry_fee',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'event_date'       => 'date',
            'max_participants' => 'integer',
            'entry_fee'        => 'decimal:2',
            'is_featured'      => 'boolean',
            'is_active'        => 'boolean',
            'sort_order'       => 'integer',
        ];
    }

    /* ---- Relationships ---- */

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'event_registrations')
            ->withPivot('status')
            ->withTimestamps();
    }

    /* ---- Scopes ---- */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('event_date', '>=', today());
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where('event_date', '<', today());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('event_type', $type);
    }

    /* ---- Accessors ---- */

    public function getRegisteredCountAttribute(): int
    {
        return $this->registrations()->where('status', 'registered')->count();
    }

    public function getSpotsLeftAttribute(): int
    {
        if ($this->max_participants === 0) {
            return PHP_INT_MAX;
        }

        return max(0, $this->max_participants - $this->registered_count);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->max_participants > 0 && $this->spots_left <= 0;
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->event_date?->isFuture() || $this->event_date?->isToday();
    }

    public function getTimeRangeAttribute(): string
    {
        $start = \Carbon\Carbon::parse($this->start_time)->format('g:i A');
        $end   = \Carbon\Carbon::parse($this->end_time)->format('g:i A');

        return "{$start} – {$end}";
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->event_type) {
            'dnd_night'  => 'D&D Night',
            'tournament' => 'Tournament',
            'game_night' => 'Game Night',
            'workshop'   => 'Workshop',
            'special'    => 'Special Event',
            default      => ucfirst(str_replace('_', ' ', $this->event_type)),
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->event_type) {
            'dnd_night'  => 'swords',
            'tournament' => 'trophy',
            'game_night' => 'dices',
            'workshop'   => 'palette',
            'special'    => 'sparkles',
            default      => 'calendar',
        };
    }
}
