<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Posts;
use App\Category;

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


        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
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
        

        //creazione nuovo post
        $new_post = new Posts();

        $slug = Str::slug($data['title'], '-');
        $count = 1;

        while (Posts::where('slug', $slug)->first()) {
            $slug .= '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        $new_post->fill($data);
        $new_post->save();

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

        if(! $post){
            abort(404);
        };

        return view('admin.posts.edit', compact('post', 'categories'));
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

        $post->delete();

        return redirect()->route('admin.posts.index')->with('deleted', $post->title);
    }


    // validation rules
    private function validation_rules() {
        return [
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
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



