<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Services\RatingService;
use App\Models\Rating;

/**
 * This controller manages API requests related to ratings, including
 * listing, viewing, creating, updating, and deleting ratings, fetching rating statistics.
 * Summary of RatingController
 * @package App\Http\Controllers\Api
 */
class RatingController extends Controller
{
    public const PERMISSIONS = [
        'delete' => 'delete rating',
    ];

    protected RatingService $ratingService;

    /**
     * Constructor to initialize the rating service.
     * Summary of __construct
     * @param RatingService $ratingService
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;

        $this->middleware('permission:' . self::PERMISSIONS['delete'])
            ->only(['destroy']);
    }

    /**
     * Normal user (not registered or logged in)
     * List all ratings
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->ratingService->listAll()
        ]);
    }

    /**
     * Normal user (not registered or logged in, can see a specific rating)
     * Show a specific rating by ID
     * Summary of show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Normal user (not registered or logged in, can see rating for a specific reservation)
     * Show rating by reservation ID
     * Summary of getByReservation
     * @param mixed $reservationId
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * signed in user: can see his own ratings:
     * Get ratings of the authenticated user
     * Summary of myRatings
     * @return \Illuminate\Http\JsonResponse
     */
    public function myRatings()
    {
        return response()->json([
            'success' => true,
            'data' => $this->ratingService->myRatings()
        ]);
    }

    /**
     * signed in user: can add a rating:
     * Store a new rating
     * Summary of store
     * @param StoreRatingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * signed in user: can edit a rating (of his own):
     * Update an existing rating
     * Summary of update
     * @param UpdateRatingRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * signed in user: can delete a rating (of his own):
     * Delete a rating
     * Summary of destroy
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Rating stats for specific roles (admin, manager...)
     * Get rating statistics
     * Summary of stats
     * @return \Illuminate\Http\JsonResponse
     */
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