@extends('layout.head_layout')

@section('content')
    <h1>Edita el comentario</h1>
    <br>

    <form method="POST" action="{{ route('edit_comment', [$topic_id, $comment->id]) }}">
        @csrf
        {{ method_field('PATCH') }}
        <label for="text">Text</label>
        <textarea  id="text"
            type="text"
            name="text"
            value="{{$comment->text}}"
            class="@error('text') is-invalid @else is-valid @enderror"
            style="width:300px; height:150px; resize:none;  ">
            {{$comment->text}}
        </textarea>
        <br>

        <input type="submit" value="Submit">

        @error('text_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('generic_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </form>
@endsection