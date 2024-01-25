@extends('layout.head_layout')

@section('content')
    <div class="mbr-section-head mb-2">
        <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Crea un nuevo topic</strong></h3>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 mx-auto mbr-form">
            <form method="POST" action="{{ route('create_topic') }}" class="mbr-form form-with-styler">
                @csrf
                <div class="col-12 form-group mb-6" data-for="title">
                    <input type="text" name="title" placeholder="Añade tu título" data-form-field="title" class="form-control" id="title">
                </div>
                <div class="col-12 form-group mb-6" data-for="topic_text">
                    <textarea type="text" name="topic_text" placeholder="Añade el texto del topic" 
                        data-form-field="topic_text" class="form-control" id="topic_text"
                        style="resize:none; height: 400px"></textarea>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
                    <button type="submit" class="btn btn-primary display-7">Crear topic</button>
                </div>
            </form>
        </div>
    </div>
    

    @error('title_error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @error('text_error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
@endsection