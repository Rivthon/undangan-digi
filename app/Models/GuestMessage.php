<?php

namespace App\Models;

use Database\Factories\GuestMessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestMessage extends Model
{
    /** @use HasFactory<GuestMessageFactory> */
    use HasFactory;

    protected $fillable = ['invitation_id', 'name', 'attendance', 'guest_count', 'message'];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
