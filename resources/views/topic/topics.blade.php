@extends('layout.head_layout')

@section('content')
    <div>
        <h1>Topics</h1> 
        @foreach ($topics as $topic)
        <a href="{{ route('single_topic', [$topic->id]) }}"><h1>{{$topic->title}} #{{$topic->id}}</h1></a>
        Post hecho por: <a href="{{ route('profile', [$topic->user_id]) }}">{{$topic->name}} {{$topic->last_name}}</a>
        @endforeach
    </div>
@endsection