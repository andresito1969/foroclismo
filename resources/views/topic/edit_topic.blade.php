@extends('layout.head_layout')

@section('content')
    <h1>Edita el topic</h1>
    <br>

    <form method="POST" action="{{ route('edit_topic', [$topic->id]) }}">
        @csrf
        {{ method_field('PATCH') }}
        <label for="title">Title</label>
        <textarea  id="title"
            type="text"
            name="title"
            value="{{$topic->title}}"
            class="@error('text') is-invalid @else is-valid @enderror"
            style="width:300px; height:150px; resize:none;  ">
            {{$topic->title}}
        </textarea>
        <br>

        <label for="text">Text</label>
        <textarea  id="text"
            type="text"
            name="text"
            value="{{$topic->topic_text}}"
            class="@error('text') is-invalid @else is-valid @enderror"
            style="width:300px; height:150px; resize:none;  ">
            {{$topic->topic_text}}
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