<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\UserMuted;


class RoomAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'is_moderator',
    ];

    public $incrementing = true;


    /**
     * Get the room that the attendee belongs to.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the user that is attending the room.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

