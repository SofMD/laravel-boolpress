<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //relation with posts
    public function posts() {
        return $this->hasMany('App\Posts');
    }
}
