<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Services\RatingService;
use App\Models\Rating;

class RatingController extends Controller
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

// Normal user (not registered or logged in)

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->ratingService->listAll()
        ]);
    }

// Normal user (not registered or logged in, can see a specific rating)
    public function show($id)
    {
        $rating = $this->ratingService->findById($id);

        if (!$rating) {
            return response()->json([
                'success' => false,
                'message' => 'Rating not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $rating
        ]);
    }

// Normal user (not registered or logged in, can see rating for a specific reservation)
    public function getByReservation($reservationId)
    {
        $rating = $this->ratingService->findByReservation($reservationId);

        if (!$rating) {
            return response()->json([
                'success' => false,
                'message' => 'There is no rating for this reservation.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $rating
        ]);
    }

// signed in user: can see his own ratings:
    public function myRatings()
    {
        return response()->json([
            'success' => true,
            'data' => $this->ratingService->myRatings()
        ]);
    }

//signed in user: can add a rating:
    public function store(StoreRatingRequest $request)
    {
        $result = $this->ratingService->store($request->validated());

        return response()->json(
            [
                'success' => $result['success'],
                'message' => $result['message'] ?? 'Rating has been added successfully.',
                'data' => $result['data'] ?? null
            ],
            $result['status']
        );
    }

//signed in user: can edit a rating (of his own):
    public function update(UpdateRatingRequest $request, $id)
    {
        $result = $this->ratingService->update($id, $request->validated());

        return response()->json(
            [
                'success' => $result['success'],
                'message' => $result['message'] ?? 'Rating has been updated successfully.',
                'data' => $result['data'] ?? null
            ],
            $result['status']
        );
    }

//signed in user: can delete a rating (of his own):
    public function destroy($id)
    {
        $result = $this->ratingService->delete($id);

        return response()->json(
            [
                'success' => $result['success'],
                'message' => $result['message']
            ],
            $result['status']
        );
    }

// Rating stats for specific roles (admin, manager...)
    public function stats()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_ratings' => Rating::count(),
                'average_score' => Rating::avg('score'),
                'ratings_by_score' => [
                    '1_star' => Rating::where('score', 1)->count(),
                    '2_stars' => Rating::where('score', 2)->count(),
                    '3_stars' => Rating::where('score', 3)->count(),
                    '4_stars' => Rating::where('score', 4)->count(),
                    '5_stars' => Rating::where('score', 5)->count(),
                ]
            ]
        ]);
    }
}