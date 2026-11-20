<?php

namespace App\Models;

use Database\Factories\GuestMessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestMessage extends Model
{
    /** @use HasFactory<GuestMessageFactory> */
    use HasFactory;

    protected $fillable = ['name', 'attendance', 'guest_count', 'message'];
}
