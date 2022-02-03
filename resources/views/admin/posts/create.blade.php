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

        <form action="{{ route('admin.posts.store')}}" method="POST">
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


            <button class="btn btn-primary" type="submit">Create Post</button>
        
        
        </form>
    </div>
@endsection