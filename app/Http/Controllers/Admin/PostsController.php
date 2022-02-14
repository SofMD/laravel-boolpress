<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Posts;
use App\Category;
use App\Tag;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::all();
        $tags = tag::all();


        return view('admin.posts.index', compact('posts', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // //validazione
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'content' => 'required'
        // ], [
        //     'required'=> 'The :attribute is a required filed!',
        //     'max' => 'Max :max characters allowed for the :attribute',
        // ]);
        $request->validate($this->validation_rules(), $this->validation_messages());
        
        $data = $request->all();

        //aggiunta immagine se presente
        if(array_key_exists('cover', $data)) {
            //salva immagine in storage e ottenere path del file caricato da salvere db
            $img_path = Storage::put('posts-covers', $data['cover']);
            $data['cover'] = $img_path;
        }
        

        //creazione nuovo post
        $new_post = new Posts();

        $slug = Str::slug($data['title'], '-');
        $count = 1;
        $base_slug = $slug;

        while (Posts::where('slug', $slug)->first()) {
            $slug .= '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        $new_post->fill($data);
        $new_post->save();

        //salvare in pivot la relazione tra post e form
        if(array_key_exists('tags', $data)) {
            $new_post->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.show', $new_post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Posts::where('slug', $slug)->first();

        if(! $post) {
            abort(404);
        }

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Posts::find($id);
        $categories = Category::all();
        $tags = Tag::all();

        if(! $post){
            abort(404);
        };

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validation_rules(), $this->validation_messages());

        $data = $request->all();
        

        $post = Posts::find($id);

        //aggiunta/ update immaagine nel post se presente
        if(array_key_exists('cover', $data)) {
            //rimuossa foto se cover non esiste
            if($post->cover) {
                Storage::delete($post->cover);
            }

            $data['cover'] = Storage::put('posts-covers', $data['cover']);
        }


        if ($data['title'] != $post->title ) {
            $slug = Str::slug($data['title'], '-');
            $count = 1;
            $base_slug = $slug;

            while (Posts::where('slug', $slug)->first()) {
                $slug = $base_slug . '-' . $count;
                $count++;
            }
            $data['slug'] = $slug;
        }
        else {
            $data['slug'] = $post->slug;
        }

        $post->update($data);

        //update relazioni pivot tra post aggiornato e tags
        if (array_key_exists('tags', $data)) {
            $post->tags()->sync($data['tags']);    
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);

        // ceck presenza cover
        if ($post->cover) {
            Storage::delete($post->cover);
        }

        $post->delete();

        // $post->tags()->detach();

        return redirect()->route('admin.posts.index')->with('deleted', $post->title);
    }


    // validation rules
    private function validation_rules() {
        return [
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'cover' => 'nullable|file|mimes:jpeg,bmp,png',
        ];
    }

    // validation rules
    private function validation_messages() {
        return [
            'required'=> 'The :attribute is a required filed!',
            'max' => 'Max :max characters allowed for the :attribute',
            'category_id.exists' => 'The selected category does not exists.'
        ];
    }
}



