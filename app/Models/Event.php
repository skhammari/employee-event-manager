<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'participation_limit',
        'location',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'participation_limit' => 'integer',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'event_participations')
            ->withPivot('is_validated', 'validated_at', 'validation_code')
            ->withTimestamps();
    }

    public function eventParticipations(): HasMany
    {
        return $this->hasMany(EventParticipation::class);
    }

    public function getRemainingSpacesAttribute()
    {
        return $this->participation_limit - $this->eventParticipations()->count();
    }
}
