<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * @property int $id
 * @property string $personal_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $address
 * @property string $qr_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'personal_id',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'qr_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($member) {
            $svg = QrCode::format('svg')
                ->size(100)
                ->generate($member->personal_id);
            
            $member->qr_code = 'data:image/svg+xml;base64,' . base64_encode($svg);
            $member->save();
        });
    }

    /**
     * Get the events that the member is participating in.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_participations')
            ->withPivot('is_validated', 'validated_at', 'validation_code')
            ->withTimestamps();
    }

    /**
     * Get the event participations for the member.
     */
    public function eventParticipations(): HasMany
    {
        return $this->hasMany(EventParticipation::class);
    }
}
