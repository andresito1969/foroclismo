@extends('layout.head_layout')

@section('content')
    <h1>Login</h1>
    <br>
    <form method="POST" action="/register">
        @csrf
        <label for="name">Name</label>
        <input id="name"
            type="text"
            name="name"
            class="@error('name') is-invalid @else is-valid @enderror">
        <br>

        <label for="last_name">Last Name</label>
        <input id="last_name"
            type="text"
            name="last_name"
            class="@error('last_name') is-invalid @else is-valid @enderror">
        <br>

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
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </form>
@endsection
