<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts;

class PostController extends Controller
{
    //posts archive
    public function index() {
        // senza impaginazione
        // $posts = Posts::all();

        // con impagnazione
        $posts = Posts::paginate(3);

        return response()->json($posts);
    }
}
