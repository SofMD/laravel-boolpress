<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //relation with posts
    public function posts() {
        return $this->belongsToMany('App\Posts');
    }
}
