<header>
    <a href="{{url('/')}}" class="logo-container">
        <img src="{{asset('images/WE-logo.png')}}" alt="logo">
    </a>
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
</header>
