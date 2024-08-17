<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'creator_id',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (Auth::check()) {
                $room->creator_id = Auth::id();
            }
        });
    }

    /**
     * Get the user that created the room.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the attendees for the room.
     */
    public function attendees(): HasMany
    {
        return $this->hasMany(RoomAttendee::class);
    }

    /**
     * Get the handRaiseRequests for the room.
     */
    public function handRaiseRequests(): HasMany
    {
        return $this->hasMany(HandRaiseRequest::class);
    }
}
