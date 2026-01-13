<?php

namespace App\Services;

use App\Models\Rating;

class WebRatingService
{
    public function getAllRatings($data)
    {
        $ratings = Rating::select('id', 'reservation_id', 'score', 'description', 'created_at', 'updated_at')
            ->when(isset($data->score), fn($query) => $query->where('score', $data->score))
            ->when(isset($data->date_From), fn($query) => $query->whereDate('created_at', '>=', $data->date_From))
            ->when(isset($data->date_To), fn($query) => $query->whereDate('created_at', '<=', $data->date_To));
;
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
