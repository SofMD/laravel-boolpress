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

    public function show($slug) {
        // prendere post da slug
        // $post = Posts::where('slug', $slug)->first();

        // b.
        $post = Posts::where('slug', $slug)->with(['category', 'tags'])->first();

        if (! $post) {
            $post['not_found'] = true;
        }

        // ritorno dati
        return response()->json($post);
    }
}
