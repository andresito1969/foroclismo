@extends('layout.head_layout')

@section('content')
    <div>
        <h1>Nombre: {{$user->name}}</h1>
    </div>
    <div>
        <h1>Apellido: {{$user->last_name}}</h1>
    </div>
    <div>
        <h1>Mail: {{$user->email}}</h1>
    </div>
@endsection