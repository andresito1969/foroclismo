@extends('layout.head_layout')

@section('content')
    <div>
        <div class="mbr-section-head mb-2" style="display: inline-block">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>{{$topic->title}}</strong></h3>
        </div>
        @if($topic->user_id == $user_id || $isAdmin)
            <a href="{{ route('edit_topic_view', [$topic->id]) }}" class="button"><span class="material-symbols-outlined">edit</span></a>
            <form method="POST" action="{{ route('delete_topic', [$topic->id]) }}" class="delete-form">
                @csrf
                {{ method_field('DELETE') }}
                <button type="submit"><span class="material-symbols-outlined">delete</span></button>
            </form>
        @endif

    </div>
    <div class="mbr-section-head mb-5">
        <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>{{$topic->topic_text}}</strong></h3>
    </div>
    <hr>
    <div>
        @foreach($comments as $comment)
            <div>
                <h3>{{$comment->text}} #{{$loop->index + 1}}</h2>
                Comentario hecho por: <a href="{{ route('profile', [$comment->user_id]) }}">{{$comment->name}} {{$comment->last_name}}</a>
                @if($comment->user_id == $user_id || $isAdmin)
                    <a href="{{ route('edit_comment_view', [$topic->id, $comment->id]) }}" class="button"><span class="material-symbols-outlined">edit</span></a>
                    <!-- 
                        Por defecto y por temas de seguridad, laravel trata cada link o cada acción enrutadora como método GET, por ende
                        no podremos usar un enlace que redirija a un método delete, con lo cual estamos obligados a crearlo dentro de un form.
                    -->
                    <form method="POST" action="{{ route('delete_comment', [$topic->id, $comment->id]) }}" class="delete-form">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit"><span class="material-symbols-outlined">delete</span></button>
                    </form>
                @endif
            </div>
            <hr>
        @endforeach
        @if($isLogged)
        <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
            <a href="{{ route('create_comment_view', [$topic->id]) }}" class="btn btn-primary display-7"><button>Nuevo Comentario</button></a>
        </div>
            
        @endif
        @error('malicious_edit_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @error('malicious_delete')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
@endsection

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" /> <!-- Delete icon-->
