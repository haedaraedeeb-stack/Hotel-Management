<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reservation_id',
        'total_amount',
        'payment_method',
        'payment_status',
    ];
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
