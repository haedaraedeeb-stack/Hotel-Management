<?php

namespace App\Services;

use App\Models\Rating;

/**
 * This service handles operations related to web ratings, including retrieval and deletion of ratings.
 * Summary of WebRatingService
 * @package App\Services
 */
class WebRatingService
{
    /**
     * Retrieve all ratings with optional filters.
     * Summary of getAllRatings
     * @param mixed $data
     */
    public function getAllRatings($data)
    {
        $ratings = Rating::select('id', 'reservation_id', 'score', 'description', 'created_at', 'updated_at')
            ->when(isset($data->score), fn($query) => $query->where('score', $data->score))
            ->when(isset($data->date_From), fn($query) => $query->whereDate('created_at', '>=', $data->date_From))
            ->when(isset($data->date_To), fn($query) => $query->whereDate('created_at', '<=', $data->date_To));
;
        return $ratings->get();
    }

    /**
     * Retrieve a specific rating by ID.
     * Summary of getRatingById
     * @param mixed $id
     * @return Rating|\Illuminate\Database\Eloquent\Collection<int, Rating>|null
     */
    public function getRatingById($id)
    {
        try {
            $rating = Rating::with('reservation.room.roomType')->find($id);
            return $rating;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return null;
        };
    }

    /**
     * Delete a rating by ID.
     * Summary of deleteRating
     * @param mixed $id
     * @return bool
     */
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
