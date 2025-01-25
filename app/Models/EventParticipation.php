<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventParticipation extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'event_id',
        'is_validated',
        'validated_at',
        'validation_code',
    ];

    protected $casts = [
        'is_validated' => 'boolean',
        'validated_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
