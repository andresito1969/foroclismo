@extends('layout.head_layout')

@section('content')
    @if(Auth::user() && Auth::user()->is_admin)
        <form method="POST" action="{{ route('ban_user', [$user->id]) }}">
            @csrf
            {{ method_field('PATCH') }}
            <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
                <button type="submit" class="btn btn-primary display-7"
                        title="Banea o desbanea el usuario"><span class="material-symbols-outlined">manage_accounts</span></button>
            </div>
        </form>
    @endif
    <div>
        <h1>Nombre: {{$user->name}}</h1>
    </div>
    <div>
        <h1>Apellido: {{$user->last_name}}</h1>
    </div>
    <div>
        <h1>Mail: {{$user->email}}</h1>
    </div>
    @if($user->banned_user)
    <div>
        <h1>Este usuario ha sido baneado del foro!</h1>
    </div>
    @endif
    @if(session()->has('success_ban_message'))
        <div class="alert alert-success">
            {{ session()->get('success_ban_message') }}
        </div>
    @endif
    @if(session()->has('success_verification'))
        <div class="alert alert-success">
            {{ session()->get('success_verification') }}
        </div>
    @endif
@endsection
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />