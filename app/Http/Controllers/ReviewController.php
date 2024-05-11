<?php

namespace App\Http\Controllers;

use App\Http\Requests\markRequest;
use App\Http\Requests\ReviewRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::all();
        return response()->json($reviews);
    }

    public function store(ReviewRequest $request)
    {

        $review = new Review();
    }

    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response()->json(null, 204);

    }

    public function show($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
    }

    public function markReview(markRequest $request, $id)
    {

        $review = Review::findOrFail($id);
        $review->Is_Marked = true;
        $review->save();
        return response()->json($review, 201);

    }

    public function addReviewToBook(Request $request, $bookId)
    {

        $request->validate([
            'comment' => 'required|string',

        ]);


        $book = Book::findOrFail($bookId);

        $review = new Review([
            'comment' => $request->comment,

        ]);


        $book->reviews()->save($review);


        return response()->json(['message' => 'Review added successfully'], 201);
    }

    public function addReviewToAuthor(Request $request, $authorId)
    {

        $request->validate([
            'comment' => 'required|string',

        ]);


        $author = Author::findOrFail($authorId);

        $review = new Review([
            'comment' => $request->comment,

        ]);


        $author->reviews()->save($review);


        return response()->json(['message' => 'Review added successfully'], 201);
    }

}
