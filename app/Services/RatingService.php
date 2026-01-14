<?php

namespace App\Services;

use App\Models\Rating;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

/**
 * This service handles operations related to ratings.
 * Summary of RatingService
 * @package App\Services
 */
class RatingService
{
    /**
     * show all ratings, for example: good for main page rating 
     * Summary of listAll
     * @return \Illuminate\Database\Eloquent\Collection<int, Rating>
     */
    public function listAll()
    {
        return Rating::with(['reservation.user', 'reservation.room'])
            ->latest()->get();
    }

    /**
     * show a rating by his id (from main page -> it takes the user for this page)
     * Summary of findById
     * @param mixed $id
     * @return Rating|\Illuminate\Database\Eloquent\Collection<int, Rating>|null
     */
    public function findById($id)
    {
        return Rating::with(['reservation.user', 'reservation.room'])->find($id);
    }

    /**
     * show rating for a specific reservation (while browser the rooms for example.)
     * Summary of findByReservation
     * @param mixed $reservationId
     * @return Rating|null
     */
    public function findByReservation($reservationId)
    {
        return Rating::where('reservation_id', $reservationId)
            ->with(['reservation.user', 'reservation.room'])
            ->first();
    }

    /**
     * show the user his own ratings
     * Summary of myRatings
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function myRatings()
    {
        $user = Auth::user();
        return Rating::whereRelation('reservation', 'user_id', $user->id)
            ->with('reservation.room')
            ->latest()
            ->paginate(5);
    }

    /**
     * create and store rating with conditions (when and where can the user make rating)
     * Summary of store
     * @param mixed $rate
     * @return array
     */
    public function store($rate)
    {

        $user = Auth::user();

        $reservation = Reservation::find($rate['reservation_id']);
        if (!$reservation) {
            return $this->fail('Reservation does not exist!.', 404);
        }

        if ($reservation->user_id !== $user->id) {
            return $this->fail('you have no auth to rate this reservation', 403);
        }

        if (!$reservation->check_out) {
            return $this->fail('you can not make rating unless you have checked out!', 400);
        }

        if (Rating::where('reservation_id', $reservation->id)->exists()) {
            return $this->fail('You have rated this reservation already.', 400);
        }

        $rating = Rating::create([
            'reservation_id' => $reservation->id,
            'score' => $rate['score'],
            'description' => $rate['description'] ?? null,
        ]);

        return $this->success($rating, 201);
    }

    /**
     * user can update his rating:
     * Summary of update
     * @param mixed $id
     * @param mixed $rate
     * @return array
     */
    public function update($id, $rate)
    {
        $user = Auth::user();

        $rating = Rating::with('reservation')->find($id);
        if (!$rating) {
            return $this->fail('no rating found', 404);
        }

        if ($rating->reservation->user_id !== $user->id) {
            return $this->fail('you have no auth to rate this reservation', 403);
        }

        $rating->update([
            'score' => $rate['score'] ?? $rating->score,
            'description' => $rate['description'] ?? $rating->description,
        ]);

        return $this->success($rating);
    }

    /**
     * user can delete his rating(s):
     * Summary of delete
     * @param mixed $id
     * @return array|array{message: string, status: int, success: bool}
     */
    public function delete($id)
    {
        $user = Auth::user();

        $rating = Rating::with('reservation')->find($id);
        if (!$rating) {
            return $this->fail('no rating found', 404);
        }

        if (
            $rating->reservation->user_id !== $user->id &&
            !$user->hasRole('admin')
        ) {
            return $this->fail('you have no auth to delete this reservation', 403);
        }

        $rating->delete();

        return [
            'success' => true,
            'status' => 200,
            'message' => 'Rating has been deleted successfully'
        ];
    }


    /**
     * help messages:
     * Summary of success
     * @param mixed $data
     * @param int $status
     * @return array{data: mixed, status: int, success: bool}
     */
    private function success($data, int $status = 200): array
    {
        return [
            'success' => true,
            'status' => $status,
            'data' => $data
        ];
    }

    /**
     * Summary of fail
     * @param string $message
     * @param int $status
     * @return array{message: string, status: int, success: bool}
     */
    private function fail(string $message, int $status): array
    {
        return [
            'success' => false,
            'status' => $status,
            'message' => $message
        ];
    }
}
