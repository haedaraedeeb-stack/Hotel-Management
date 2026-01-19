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
    protected $hidden = ['created_at','updated_at'];

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_service');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
