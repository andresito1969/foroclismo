@extends('layout.head_layout')

@section('content')
    <div class="mbr-section-head mb-2">
        <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Edita el topic</strong></h3>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 mx-auto mbr-form">
        </div>
    </div>
    <form method="POST" action="{{ route('edit_topic', [$topic->id]) }}" class="mbr-form form-with-styler">
        @csrf
        {{ method_field('PATCH') }}
        <div class="col-12 form-group mb-6" data-for="title">
            <input type="text" name="title" value="{{$topic->title}}" data-form-field="title" class="form-control" id="title">
        </div>

        <div class="col-12 form-group mb-6" data-for="topic_text">
            <textarea type="text" name="text" placeholder="Añade el texto del topic" 
                data-form-field="topic_text" class="form-control" id="topic_text"
                style="resize:none; height: 400px">{{$topic->topic_text}}</textarea>
                
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
            <button type="submit" class="btn btn-primary display-7">Editar topic</button>
        </div>
        @error('text_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('title_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('generic_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </form>
@endsection