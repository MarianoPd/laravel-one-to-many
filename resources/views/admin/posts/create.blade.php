@extends('layouts.admin')
@section('content')

@if ($errors->any())
        
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li >{{$error}}</li>
            @endforeach
        </ul>        
    </div>
    
@endif

<div class="container">
    <h1>
        Create new Post
    </h1>
    <form action="{{route('admin.posts.store')}}" method="POST">
        @csrf

        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                value="{{old('title')}}"
                id="title"  name="title" placeholder="...">
          @error('title')
              <p class="invalid-feedback">{{$message}}</p>
          @enderror
        </div>
        <div class="form-group">
          <label for="content">Content</label>
          <textarea  class="form-control @error('content') is-invalid @enderror" 
                id="content" name="content" placeholder="...">
              {{old('content')}}
          </textarea>
          @error('content')
              <p class="invalid-feedback">{{$message}}</p>
          @enderror
        </div>
        <div class="form-goup">
            <label for="category_id">Insert Category</label>
            <select name="category_id" id="category_id" class="form-select">
                
                @foreach ($categories as $category)
                    <option 
                    @if($category->id == old('category_id')) selected  @endif
                    value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        
        
        <button type="submit" class="btn btn-primary">Create</button>
        <button type="reset" class="btn btn-secondary" >Reset</button>
      </form>
</div>


@endsection

@section('title')
 | Create Post
@endsection