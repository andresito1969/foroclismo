@extends('layout.head_layout')

@section('content')
    <h1>Crea un nuevo tema</h1>
    <br>
    <form method="POST" action="/create_topic">
        @csrf
        <label for="title">Título</label>
        <input id="title"
            type="text"
            name="title"
            class="@error('title') is-invalid @else is-valid @enderror">
        <br>

        <label for="topic_text">Texto</label>
        <input id="topic_text"
            type="text"
            name="topic_text"
            class="@error('topic_text') is-invalid @else is-valid @enderror">
        <br>
        <input type="submit" value="Submit">
    </form>

    @error('title_error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @error('text_error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
@endsection