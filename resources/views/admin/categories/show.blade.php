@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ $category->name }}</h1>

        @foreach ($category->posts as $post)
            <article>
                <h2>{{ $post->title }}</h2>
                <a class="btn btn-success" href="{{ route('admin.posts.show', $post->slug) }}">SHOW</a>
                <a class="btn btn-primary" href="{{ route('admin.posts.edit', $post->id) }}">EDIT</a>
            </article>            
        @endforeach
        
    </div>
@endsection