<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'start_date',
        'end_date',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
