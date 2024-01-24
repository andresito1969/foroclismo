@extends('layout.head_layout')

@section('content')
    <h1>Crea un nuevo comentario</h1>
    <br>

    <form method="POST" action="{{ route('create_comment', [$topic_id]) }}">
        @csrf
        <textarea  id="text"
            type="text"
            name="text"
            class="@error('text') is-invalid @else is-valid @enderror"
            style="width:300px; height:150px; resize:none;  ">
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