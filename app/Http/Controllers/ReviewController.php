<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\BookReview;
use App\Book;

class ReviewController extends Controller
{
    //

    public function create($id,Request $request){
        $validated = $this->validate($request, [
            'review' => 'required|numeric|min:1|max:10',
            'comment' => 'required',
        ]);
        
        if($validated){
            $book = Book::find($id);
            // return auth()->user()->id;
            // $bookReviews = BookReview::where('book_id', $id)->get();
            // return count($bookReviews);
            if($book){
                $check = BookReview::where([
                    ['book_id', $id],
                    ['user_id', auth()->user()->id]
                ])->exists();
                if ($check) {
                    return response()->json([
                        'error' => 'Book Already reviewed by user'
                    ], 422);
                } else{
                    $new =  New BookReview;
                    $new->review = $request['review'];
                    $new->comment = $request['comment'];
                    $new->user_id = auth()->user()->id;
                    $new->book_id = $id;
                    $new->save();

                    $bookReviews = BookReview::where('book_id', $id)->avg('review');
                    $oldReview = BookReview::where('book_id', $id)->get();
                    $review = Review::find($book->review->id);
                    $review->count = count($oldReview);
                    $review->avg = $bookReviews;
                    $review->save();

                    return response()->json([
                        'message' => 'New Review Made',
                        'data' => $new,
                        'book' => $review
                    ], 201);
                }
            }else{
                return response()->json([
                    'error' => 'Invalid Book Id'
                ], 404);
            }
        }

    }
}
