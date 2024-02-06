@extends('layout.head_layout')

@section('form')
    <div class="mbr-section-head mb-5">
        <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Login</strong></h3>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 mx-auto mbr-form">
            <form method="POST" action="/login" class="mbr-form form-with-styler">
                @csrf
                <div class="col-12 form-group mb-6" data-for="email">
                    <input type="email" name="email" placeholder="email" data-form-field="email" class="form-control" id="email">
                </div>
                <div class="col-12 form-group mb-6" data-for="password">
                    <input type="password" name="password" placeholder="password" data-form-field="password" class="form-control" id="password">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
                    <button type="submit" class="btn btn-primary display-7">Logear</button>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
    @error('ban_message')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    @if(session()->has('created_user'))
        <div class="alert alert-success">
            {{ session()->get('created_user') }}
        </div>
    @endif
@endsection