<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $guarded = [];

    
    public function author(){
        return $this->belongsTo('App\Author');
    }

    //in progress
    // public function authors(){
    //     return $this->belongsToMany('App\Author');
    // }

    public function book_reviews(){
        return $this->hasMany('App\BookReview');
    }

    public function review(){
        return $this->hasOne('App\Review');
    }

}
