<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author;
use App\Review;
use phpDocumentor\Reflection\DocBlock\Description;

class BookController extends Controller
{
    //

    public function allBooks(){
        $books = new Book;
        $queries = [];
        $columns = [
            'title','avg_review'
        ];
        foreach ($columns as $column) {
            if (request()->has($column)) {
                $books = $books->where($column,request($column));
                $queries[$column] = request($column);
            } 
            
        }

        if (request()->has('sort')) {
            $books = $books->Orderby('title', request('sort'));
            $queries['sort'] = request('sort');
        }

        $books= $books->with(['author', 'review'])->paginate(15)->appends($queries);

        return response($books, 200);
    }

    public function addbook(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'isbn' => 'required|unique:books|digits:13',
            'description' => 'required',
            'author' => 'required',
        ]);
        $check  = Author::find($request['author']);
        
        if ($check) {
            $isbn = $request['isbn'];
            $title = $request['title'];
            $description = $request['description'];
            $author = $request['author'];
    
            $new = new Book;
            $new->title = $title;
            $new->isbn = $isbn;
            $new->description = $description;
            $new->author_id = $author;
            $new->save();
    
            $newReview = new Review;
            $newReview->avg = 0;
            $newReview->count = 0;
            $newReview->book_id = $new->id;
            $newReview->save();
    
          
    
            $data = Book::with('review')->find($new->id);
            
            return response()->json([
                'message' => 'New Book Successfully Created',
                'data' => $data,
            ], 201);
            
        } else{
            return response()->json([
                'error' => 'Invalid Author'
            ], 422);
        }
        

    }

    public function createAuthor(Request $request){
        $name = $request['name'];
        $surname = $request['surname'];
        
        $new =new Author;
        $new->name = $name;
        $new->surname = $surname;
        $new->save();

        return response()->json([
            'message' => 'New Author Successfully Added',
            'data' => $new
        ],201);
    }
}
