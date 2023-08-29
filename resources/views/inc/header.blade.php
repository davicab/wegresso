<header>
    <div class="menu-mobile">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
    <a href="{{url('/')}}" class="logo-container">
        <img src="{{asset('images/WE-logo.png')}}" alt="logo">
        <span class="logo-span">gresso</span>
    </a>
    <nav class="menu desk">
        <a href="{{url('/')}}/cursos" class="nav-cursos">Cursos</a>
        <a href="{{url('/')}}/cursos/graficos" class="nav-graficos">Graficos</a>
    </nav>
    <div class="login-but desk">
        <a 
        @if(!isset($auth))
            href="{{url('/')}}/login"
        @else 
            href="{{url('/')}}/perfil"
        @endif
        >
            <img src="{{asset('images/account.png')}}" alt="">
        </a>
    </div>
    <div class="side-menu">
        <nav class="menu">
            <a href="{{url('/')}}/cursos" class="nav-cursos">Cursos</a>
            <a href="{{url('/')}}/cursos/graficos" class="nav-graficos">Graficos</a>
        </nav>
        <div class="login-but">
            <a 
            @if(!isset($auth))
                href="{{url('/')}}/login"
            @else 
                href="{{url('/')}}/perfil"
            @endif
            >
                <img src="{{asset('images/account.png')}}" alt="">
            </a>
        </div>
    </div>
</header>
