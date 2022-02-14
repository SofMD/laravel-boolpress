@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ $post->title }}</h1>

        <div class="mb-5">
            <div class="my-4">
                <strong>Category:</strong>
                @if($post->category) {{ $post->category->name }} @else Uncategorized @endif
            </div>
            
            <a class="btn btn-warning " href="{{ route('admin.posts.edit', $post->id)}}">Edit</a>
            <a class="btn btn-primary" href="{{ route('admin.posts.index', $post->id)}}">Back to Archive</a>
            
        </div>

        <div class="row mb-5">
            <div class="{{ $post->cover ? 'col-md-6' : 'col'}}">
                {!! $post->content !!}
            </div>
            @if ($post->cover)
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset('storage/' . $post->cover )}}" alt="{{ $post->title}}">
                </div>
            @endif
            
        </div>

        @if(!$post->tags->isEmpty())
            <h5 class="mt-5">Tags</h5>

            @foreach ($post->tags as $tag)
                <span class="badge badge-primary"> {{ $tag->name }}</span>
            @endforeach

            
        @else
           <p>No tags for this post</p>
        @endif


    </div>
@endsection