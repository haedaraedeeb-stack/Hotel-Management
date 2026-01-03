<?php

namespace App\Services;

use App\Models\Rating;

class WebRatingService
{
    public function getAllRatings($data)
    {
        $ratings = Rating::select('id', 'reservation_id', 'score', 'description','created_at', 'updated_at');

        if (isset($data->score)) {
            $ratings->where('score', $data->score);
        }

        if (isset($data->date_From)) {
            $ratings->whereDate('created_at','>=' ,$data->date_From);
        }

        if (isset($data->date_To)) {
            $ratings->whereDate('created_at','<=' ,$data->date_To);
        }

        return $ratings->get();
    }

    public function getRatingById($id)
    {
        try {
            $rating = Rating::with('reservation.room.roomType')->find($id);
            return $rating;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return null;
        };
    }

    public function deleteRating($id)
    {
        $rating = Rating::find($id);
        if ($rating) {
            $rating->delete();
            return true;
        }
        return false;
    }
}
