@extends('layout.head_layout')

@section('content')
    <div class="mbr-section-head mb-2">
        <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Edita el comentario</strong></h3>
    </div>

    <form method="POST" action="{{ route('edit_comment', [$topic_id, $comment->id]) }}">
        @csrf
        {{ method_field('PATCH') }}
        <div class="col-12 form-group mb-6" data-for="name">
            <textarea type="text" name="text" value="{{$comment->text}}"
                        data-form-field="text" class="form-control" id="text"
                        style="resize:none; height: 400px">{{$comment->text}}</textarea>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
            <button type="submit" class="btn btn-primary display-7">Editar</button>
        </div>

        @error('text_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('generic_error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </form>
@endsection