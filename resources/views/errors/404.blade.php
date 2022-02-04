@extends('layouts.admin')
@section('content')

    <div class="container">
        <h1>404</h1>
        <p>{{$exception->getMessage()}}</p>
    </div>

@endsection