@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>Blog Posts</h2>

        @if ($posts->isEmpty())
            <p>No post found yet.</p>
        @else

           <table class="table">
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Title</th>
                       <th colspan="3">Actions</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($posts as $post)

                   <tr>
                       <td>{{ $post->id}}</td>
                       <td>{{ $post->title}}</td>
                       <td>SHOW</td>
                       <td>EDIT</td>
                       <td>DELETE</td>
                       
                   </tr>
                       
                   @endforeach
               </tbody>
           </table>
        @endif
    </div>

@endsection
