@extends('layout.head_layout')

@section('content')
    <div>
        <h1>Tienes que verificar tu email para poder usar funciones avanzadas!</h1>
        <div>
            <form method="POST" action="/verification.send" class="mbr-form form-with-styler">
                @csrf
                <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
                    <button type="submit" class="btn btn-primary display-7">Click aquí para verificar!</button>
                </div>
            </form>
        </div>
    </div>
@endsection