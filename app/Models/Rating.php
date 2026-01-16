<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $fillable = [
        'reservation_id',
        'score',
        'description',
    ];
    protected $hidden = ['created_at','updated_at'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
