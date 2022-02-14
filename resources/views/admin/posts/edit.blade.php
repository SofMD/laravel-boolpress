@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">EDIT {{ $post->title }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $post->title) }}">
                @error('title')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content*</label>
                <textarea class="form-control" name="content" id="content" rows="6" >{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>

            {{-- categories --}}
            <div class="mb-3">
                <label for="category_id" >Category</label>
                <select class="form-control" name="category_id" id="category_id" >
                    <option value="">Uncategorized</option>
                    @foreach ($categories as $category)
                         <option value="{{ $category->id}}"
                             @if($category->id == old('category_id', $post->category_id)) selected @endif>
                            
                            {{ $category->name }}
                        </option>
                        
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>

             {{-- tags --}}
             <div class="my-4">
                <h5>Tags</h5>

                @foreach ($tags as $tag)
                    <span class="d-inline-block mx-3">
                        <input type="checkbox" name="tags[]" id="tag{{ $loop->iteration }}" value="{{ $tag->id }}"
                          @if( $errors->any() && in_array($tag->id, old('tags'))) 
                              checked 
                          @elseif(!$errors->any() && $post->tags->contains($tag->id))  
                              checked
                          @endif>

                          
                        <label for="tag{{ $loop->iteration }}">
                            {{ $tag->name }}                        
                        </label>
                    </span>                    
                @endforeach
                @error('tags')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- cover image --}}
            <div class="my-4">
                <label class="form-label" for="cover">Post Image</label>
                @if ($post->cover)
                   <figure class="mb-3">
                       <img width="200" src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}">
                   </figure>
                @endif
                <input type="file" class="form-control-file" name="cover" id="cover">
                
                @error('cover')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">Update Post</button>
        
        
        </form>
    </div>
@endsection