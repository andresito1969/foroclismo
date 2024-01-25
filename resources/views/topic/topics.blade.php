@extends('layout.head_layout')

@section('content')
<div>
    <div>
        <div class="mbr-section-head mb-2">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Topics</strong></h3>
        </div>
        @if($isLogged)
            <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn mb-5">
                <a href="{{ route('create_topic_view') }}" class="button btn btn-primary display-7">Nuevo Topic</a>
            </div>
        @endif
        @foreach ($topics as $topic)
        <a href="{{ route('single_topic', [$topic->id]) }}"><h1>{{$topic->title}} #{{$topic->id}}</h1></a>
        Post hecho por: <a href="{{ route('profile', [$topic->user_id]) }}">{{$topic->name}} {{$topic->last_name}}</a>
        <hr>
        @endforeach
    </div>
</div>
@endsection