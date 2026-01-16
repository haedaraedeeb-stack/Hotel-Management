<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type',

    ];
    protected $hidden = ['created_at','updated_at'];
    public function imageable()
    {
        return $this->morphTo();
    }
}
