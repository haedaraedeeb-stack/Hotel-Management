<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
    ];

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_service');
    }
    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
