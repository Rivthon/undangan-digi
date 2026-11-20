<?php

namespace App\Models;

use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'slug', 'bride_name', 'bride_short_name', 'bride_parents', 'bride_instagram',
        'groom_name', 'groom_short_name', 'groom_parents', 'groom_instagram', 'event_at',
        'display_date', 'akad_time', 'reception_time', 'venue', 'address', 'maps_url', 'quote',
    ];

    protected function casts(): array
    {
        return ['event_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guestMessages(): HasMany
    {
        return $this->hasMany(GuestMessage::class);
    }

    /** @return array<string, mixed> */
    public function displayData(): array
    {
        return [
            'bride' => ['name' => $this->bride_name, 'short_name' => $this->bride_short_name, 'parents' => $this->bride_parents, 'instagram' => $this->bride_instagram],
            'groom' => ['name' => $this->groom_name, 'short_name' => $this->groom_short_name, 'parents' => $this->groom_parents, 'instagram' => $this->groom_instagram],
            'date' => $this->event_at->format('Y-m-d H:i:s'),
            'display_date' => $this->display_date,
            'akad' => $this->akad_time,
            'reception' => $this->reception_time,
            'venue' => $this->venue,
            'address' => $this->address,
            'maps_url' => $this->maps_url,
            'quote' => $this->quote,
        ];
    }
}
