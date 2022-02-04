<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'category_id',
    ];


    //relation with categories
    public function category(){
        return $this->belongsTo('App\Category');
    }

    //relation with tags
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
}
