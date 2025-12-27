<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
        'price_per_night',
        'floor',
        'view',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservations::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
