<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $appends = ['current_price'];
    protected $hidden = ['created_at', 'updated_at'];
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
        return $this->hasMany(Reservation::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getCurrentPriceAttribute()
    {
        if(!empty($this->price_per_night) && $this->price_per_night > 0)
        {
            return $this->price_per_night;
        }
        return $this->roomType->base_price;
    }
}
