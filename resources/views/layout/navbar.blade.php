<section data-bs-version="5.1" class="menu menu2 cid-tJS6tZXiPa" once="menu" id="menu02-0">
	<nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
        <a class="nav-link link text-black text-primary display-4" href="{{ route('home')}}">
            <img src="{{ asset('favicon.ico') }}" alt="Foroclismo" style="height: 3rem;">
        </a>
		<div class="container">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                    <li class="nav-item">
						<a class="nav-link link text-black text-primary display-4" href="{{ route('home')}}">Inicio</a>
					</li>
                    @if(!Auth::check())
                        <li class="nav-item">
                            <a class="nav-link link text-black text-primary display-4" href="{{ route('login')}}" aria-expanded="false">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-black text-primary display-4" href="{{ route('register_view')}}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link link text-black text-primary display-4" href="{{ route('profile', [Auth::id()]) }}" aria-expanded="false">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="nav-link link text-black text-primary display-4" type="submit">Logout</button>
                            </form>
                        </li>
                    @endif
                </ul>
			</div>
		</div>
	</nav>
</section>