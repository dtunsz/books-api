<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //

    public function authors(){
        return $this->hasMany('App\Book');
    }

    //in progress
    // public function books(){
    //     return $this->belongsToMany('App\Book');
    // }
}
