@extends('layout.head_layout')

@section('content')
    <h1>{{$topic->title}}</h1>
    <h1>{{$topic->topic_text}}</h1>
    @if($topic->user_id == $user_id || $isAdmin)
        <a href="{{ route('edit_topic_view', [$topic->id]) }}">Editar</a>

        <form method="POST" action="{{ route('delete_topic', [$topic->id]) }}">
            @csrf
            {{ method_field('DELETE') }}
            <input type="submit" value="Borrar">
        </form>
    @endif
    <div>
        @foreach($comments as $comment)
            <div>
                <h3>{{$comment->text}} #{{$loop->index + 1}}</h2>
                Comentario hecho por: <a href="{{ route('profile', [$comment->user_id]) }}">{{$comment->name}} {{$comment->last_name}}</a>
                @if($comment->user_id == $user_id || $isAdmin)
                    <a href="{{ route('edit_comment_view', [$topic->id, $comment->id]) }}">Editar</a>
                    <!-- 
                        Por defecto y por temas de seguridad, laravel trata cada link o cada acción enrutadora como método GET, por ende
                        no podremos usar un enlace que redirija a un método delete, con lo cual estamos obligados a crearlo dentro de un form.
                    -->
                    <form method="POST" action="{{ route('delete_comment', [$topic->id, $comment->id]) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Borrar">
                    </form>
                @endif
            </div>
        @endforeach
        @if($isLogged)
            <a href="{{ route('create_comment_view', [$topic->id]) }}"><button>Nuevo Comentario</button></a>
        @endif
        @error('malicious_edit_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @error('malicious_delete')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
@endsection