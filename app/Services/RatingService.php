<?php

namespace App\Services;

use App\Models\Rating;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class RatingService
{
    // show all ratings, for example: good for main page rating 
    public function listAll()
    {
        try {
            return Rating::with(['reservation.user', 'reservation.room'])
                ->latest()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching all ratings: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error fetching ratings',
            ], 500));
        }
    }

    // show a rating by his id (from main page -> it takes the user for this page)
    public function findById($id)
    {
        try {
            $rating = Rating::with(['reservation.user', 'reservation.room'])->find($id);
            if (!$rating) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'Rating not found',
                ], 404));
            }
            return $rating;
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error fetching rating by ID: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error fetching rating',
            ], 500));
        }
    }

    // show rating for a specific reservation (while browser the rooms for example.)
    public function findByReservation($reservationId)
    {
        try {
            return Rating::where('reservation_id', $reservationId)
                ->with(['reservation.user', 'reservation.room'])
                ->first();
        } catch (\Exception $e) {
            Log::error('Error fetching rating by reservation: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error fetching rating for reservation',
            ], 500));
        }
    }

    // show the user his own ratings 
    public function myRatings()
    {
        try {
            $user = Auth::user();
            return Rating::whereRelation('reservation', 'user_id', $user->id)
                ->with('reservation.room')
                ->latest()
                ->paginate(5);
        } catch (\Exception $e) {
            Log::error('Error fetching user ratings: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error fetching your ratings',
            ], 500));
        }
    }

    // create and store rating with conditions (when and where can the user make rating)
    public function store($rate)
    {
        try {
            $user = Auth::user();

            $reservation = Reservation::find($rate['reservation_id']);
            if (!$reservation) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'Reservation does not exist!',
                ], 404));
            }

            if ($reservation->user_id !== $user->id) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'You have no authorization to rate this reservation',
                ], 403));
            }

            if (!$reservation->check_out) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'You cannot rate unless you have checked out!',
                ], 400));
            }

            if (Rating::where('reservation_id', $reservation->id)->exists()) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'You have rated this reservation already',
                ], 400));
            }

            $rating = Rating::create([
                'reservation_id' => $reservation->id,
                'score' => $rate['score'],
                'description' => $rate['description'] ?? null,
            ]);

            return $rating;
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error creating rating: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error creating rating',
            ], 500));
        }
    }

    // user can update his rating:
    public function update($id, $rate)
    {
        try {
            $user = Auth::user();

            $rating = Rating::with('reservation')->find($id);
            if (!$rating) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'Rating not found',
                ], 404));
            }

            if ($rating->reservation->user_id !== $user->id) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'You have no authorization to update this rating',
                ], 403));
            }

            $rating->update([
                'score' => $rate['score'] ?? $rating->score,
                'description' => $rate['description'] ?? $rating->description,
            ]);

            return $rating;
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating rating: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error updating rating',
            ], 500));
        }
    }

    // user can delete his rating(s):
    public function delete($id)
    {
        try {
            $user = Auth::user();

            $rating = Rating::with('reservation')->find($id);
            if (!$rating) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'Rating not found',
                ], 404));
            }

            // if (
            //     $rating->reservation->user_id !== $user->id &&
            //     !$user->hasRole('admin')
            // ) {
            //     throw new HttpResponseException(response()->json([
            //         'success' => false,
            //         'message' => 'You have no authorization to delete this rating',
            //     ], 403));
            // }

            $rating->delete();
            
            return $rating; // Return deleted rating or just true
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error deleting rating: ' . $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error deleting rating',
            ], 500));
        }
    }
}