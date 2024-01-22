@extends('layout.head_layout')

@section('content')
    <h1>Crea un nuevo comentario</h1>
    <br>

    <form method="POST" action="{{ route('create_comment', [$topic_id]) }}">
        @csrf
        <label for="text">Text</label>
        <input id="text"
            type="text"
            name="text"
            class="@error('text') is-invalid @else is-valid @enderror">
        <br>

        <input type="submit" value="Submit">
    </form>
@endsection