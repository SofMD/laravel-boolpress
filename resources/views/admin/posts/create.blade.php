@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">CREATE A NEW POST</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.posts.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
                @error('title')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content*</label>
                <textarea class="form-control" name="content" id="content" rows="6" value="{{ old('content') }}"></textarea>
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
                             @if($category->id == old('category_id')) selected @endif>
                            
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
                          @if(in_array($tag->id, old('tags', []))) checked @endif>
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
                <input type="file" class="form-control-file" name="cover" id="cover">
                
                @error('cover')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <button class="btn btn-primary" type="submit">Create Post</button>
        
        
        </form>
    </div>
@endsection