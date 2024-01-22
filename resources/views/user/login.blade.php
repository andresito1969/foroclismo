@extends('layout.head_layout')

@section('content')
    <h1>Login</h1>
    <br>
    <form method="POST" action="/login">
        @csrf
        <label for="email">Email address</label>
        <input id="email"
            type="text"
            name="email"
            class="@error('email') is-invalid @else is-valid @enderror">
        <br>

        <label for="password">Password</label>        
        <input id="password"
            type="text"
            name="password"
            class="@error('password') is-invalid @else is-valid @enderror">
        <br>

        <input type="submit" value="Submit">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </form>
@endsection
