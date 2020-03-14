<?php

use Illuminate\Http\Request;
use App\Http\Controllers\PassportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::post('books/{id}/reviews', 'ReviewController@create');
});

Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::post('/books', 'BookController@addBook');
});

Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');

Route::get('/books','BookController@allBooks');

Route::get('books/{title}','BookController@aBooks');



Route::post('/authors', 'BookController@createAuthor');



// Route::post('books/{id}/reviews', 'ReviewController@create');