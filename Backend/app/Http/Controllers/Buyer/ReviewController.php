<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\ReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        $review = Review::create([
            'buyer_id' => auth()->id(),
            'product_id' => $request->input('product_id'),
            'order_id' => $request->input('order_id'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'is_approved' => true,
        ]);

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\ReviewResource($review),
            'Review submitted successfully.',
            201
        );
    }
}
