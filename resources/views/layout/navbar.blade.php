<div>
    <a href="{{ route('login')}}">Login</a>
    <a href="{{ route('register_view')}}">Register</a>
    <a href="{{ route('home')}}">Home</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>