<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Services\WebRatingService;
use Illuminate\Http\Request;

/**
 * This controller manages rating-related web requests,
 * including listing, showing, and deleting ratings.
 * Summary of RatingController
 * @package App\Http\Controllers\Web
 */
class RatingController extends Controller
{
    protected $ratingService;
    /**
     * RatingController constructor.
     * Summary of __construct
     * @param WebRatingService $ratingService
     */
    public function __construct(WebRatingService $ratingService)
    {
        $this->ratingService = $ratingService;
        $this->middleware('permission:rating-list')->only(['index']);
        $this->middleware('permission:rating-show')->only(['show']);
        $this->middleware('permission:rating-delete')->only(['destroy']);
    }

    /**
     * Display a listing of ratings.
     * Summary of index
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $ratings = $this->ratingService->getAllRatings($request);
        $data = $request->all();
        return view('ratings.index', compact('ratings', 'data'));
    }

    /**
     * Show the form for creating a new rating.
     * Summary of create
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created rating in storage.
     * Summary of store
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified rating.
     * Summary of show
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $rating = $this->ratingService->getRatingById($id);
        if (!$rating) {
            return redirect()->route('ratings.index')->with('error', 'Rating not found.');
        }
        return view('ratings.show', compact('rating'));
    }

    /**
     * Show the form for editing the specified rating.
     * Summary of edit
     * @param string $id
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified rating in storage.
     * Summary of update
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified rating from storage.
     * Summary of destroy
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $deleted = $this->ratingService->deleteRating($id);
        if ($deleted) {
            return redirect()->route('ratings.index')->with('success', 'Rating deleted successfully.');
        } else {
            return redirect()->route('ratings.index')->with('error', 'Rating not found.');
        }
    }
}
