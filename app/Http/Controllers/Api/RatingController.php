<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Services\RatingService;
use Illuminate\Http\Exceptions\HttpResponseException;

class RatingController extends Controller
{

    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;

        $this->middleware('role:admin|manager')
            ->only(['stats']);
    }

    // Normal user (not registered or logged in)
    public function index()
    {
        try {
            $ratings = $this->ratingService->listAll();
            return $this->success('', $ratings, 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    // Normal user (not registered or logged in, can see a specific rating)
    public function show($id)
    {
        try {
            $rating = $this->ratingService->findById($id);
            return $this->success('', $rating, 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    // Normal user (not registered or logged in, can see rating for a specific reservation)
    public function getByReservation($reservationId)
    {
        try {
            $rating = $this->ratingService->findByReservation($reservationId);
            if (!$rating) {
                return $this->error('There is no rating for this reservation', 404);
            }
            return $this->success('', $rating, 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    // signed in user: can see his own ratings:
    public function myRatings()
    {
        try {
            $ratings = $this->ratingService->myRatings();
            return $this->success('', $ratings, 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    // signed in user: can add a rating:
    public function store(StoreRatingRequest $request)
    {
        try {
            $rating = $this->ratingService->store($request->validated());
            return $this->success('Rating has been added successfully', $rating, 201);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    // signed in user: can edit a rating (of his own):
    public function update(UpdateRatingRequest $request, $id)
    {
        try {
            $rating = $this->ratingService->update($id, $request->validated());
            return $this->success('Rating has been updated successfully', $rating, 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    // signed in user: can delete a rating (of his own):
    public function destroy($id)
    {
        try {
            $rating = $this->ratingService->delete($id);
            return $this->success('Rating has been deleted successfully', null, 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred', 500);
        }
    }

    // Rating stats for specific roles (admin, manager...)
    public function stats()
    {
        try {
            $stats = $this->ratingService->getStats();
            return $this->success('', $stats, 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred while fetching stats', 500);
        }
    }
}
