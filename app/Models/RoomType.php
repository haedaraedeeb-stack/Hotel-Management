<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'type',
        'description',
        'base_price',
    ];
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'room_type_service');
    }
    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
