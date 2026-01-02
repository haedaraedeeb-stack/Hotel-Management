<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Services\WebRatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;
    /**
     * Display a listing of the resource.
     */
    public function __construct(WebRatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    public function index(Request $request)
    {
        $ratings = $this->ratingService->getAllRatings($request);
        $data = $request->all();
        return view('ratings.index', compact('ratings', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
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
