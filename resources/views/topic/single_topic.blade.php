@extends('layout.head_layout')

@section('content')
    <h1>{{$topic->title}}</h1>
    <h1>{{$topic->topic_text}}</h1>
    <div>
        @foreach($comments as $comment)
            <div>
                <h3>{{$comment->text}} #{{$loop->index + 1}}</h2>
                Comentario hecho por: <a href="{{ route('profile', [$comment->user_id]) }}">{{$comment->name}} {{$comment->last_name}}</a>
            </div>
        @endforeach
        @if($isLogged)
            <a href="{{ route('create_comment_view', [$topic->id]) }}"><button>Nuevo Comentario</button></a>
        @endif
    </div>
@endsection