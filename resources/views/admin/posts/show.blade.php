@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ $post->title }}</h1>

        <div class="mb-5">
            
            <a class="btn btn-warning " href="{{ route('admin.posts.edit', $post->id)}}">Edit</a>
            <a class="btn btn-primary" href="{{ route('admin.posts.index', $post->id)}}">Back to Archive</a>
            <div class="my-4">
                <strong>Category:</strong>
                @if($post->category) {{ $post->category->name }} @else Uncategorized @endif
                
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! $post->content !!}
            </div>
            <div class="col-md-6">
                Image ...
            </div>
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