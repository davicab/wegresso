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
            <a href="{{url('/')}}/cursos" class="nav-cursos">
                <svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6116 0.302028C10.8551 0.232733 11.1119 0.23267 11.3553 0.301762C11.8729 0.44863 12.3952 0.584853 12.9192 0.72153C15.38 1.36334 17.8793 2.01516 20.1028 3.82618L21.1267 4.66016C21.542 4.99845 21.7498 5.49918 21.75 6V13C21.75 13.4142 21.4142 13.75 21 13.75C20.5858 13.75 20.25 13.4142 20.25 13V8.05668L20.0871 8.18963C19.3166 8.81834 18.5128 9.30655 17.6888 9.70286C17.7282 9.79397 17.75 9.89444 17.75 10V14.2939C17.75 15.4272 17.0548 16.4444 15.9989 16.8561L11.9989 18.4156C11.3565 18.666 10.6435 18.666 10.0011 18.4156L6.0011 16.8561C4.94522 16.4444 4.25 15.4272 4.25 14.2939V10C4.25 9.89177 4.27292 9.7889 4.31418 9.69597C3.48383 9.29733 2.67373 8.80626 1.89724 8.17382L0.873302 7.33983C0.0426437 6.66327 0.0422074 5.33693 0.872146 4.65967L1.91292 3.81037C4.12037 2.00904 6.60193 1.36111 9.04453 0.72335C9.56971 0.586228 10.0931 0.449573 10.6116 0.302028ZM20.25 6.0006C20.25 5.91051 20.2136 5.85102 20.1794 5.8232L19.1555 4.98922C17 3.5 15.0794 2.84319 12.6399 2.20216C12.1035 2.06121 11.5519 1.91626 10.984 1.75559C10.4135 1.91742 9.8599 2.06306 9.3217 2.20465C6.9018 2.84128 4.79323 3.39601 2.86128 4.97253L1.8205 5.82184C1.78631 5.84973 1.74996 5.90931 1.75 5.9994C1.75004 6.08949 1.78643 6.14898 1.82058 6.1768L2.84453 7.01078C4.79285 8.59767 6.92065 9.15681 9.36011 9.79784C9.89653 9.9388 10.4481 10.0837 11.016 10.2444C11.5865 10.0826 12.14 9.93696 12.6782 9.79538C15.0981 9.15875 17.2068 8.60399 19.1387 7.02747L20.1795 6.17816C20.2137 6.15029 20.25 6.09054 20.25 6.0006ZM12.9555 11.2766C14.0553 10.9895 15.163 10.7003 16.25 10.3046V14.2939C16.25 14.8091 15.934 15.2714 15.454 15.4585L11.454 17.018C11.1621 17.1318 10.8379 17.1318 10.546 17.018L6.54596 15.4585C6.06601 15.2714 5.75 14.8091 5.75 14.2939V10.2961C6.84877 10.6963 7.96869 10.9884 9.08078 11.2785C9.60482 11.4151 10.1271 11.5514 10.6447 11.6982C10.8881 11.7673 11.145 11.7673 11.3884 11.698C11.9069 11.5504 12.4303 11.4138 12.9555 11.2766Z" fill="white"/>
                </svg>
                Cursos
            </a>
            <a href="{{url('/')}}/cursos/graficos" class="nav-graficos">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28 26H4V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M26.0002 8L16.0002 18L12.0002 14L4.00024 22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M26.0002 13V8H21.0002" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Graficos
            </a>
        </nav>
        <div class="login-but">
            <a
            @if(!isset($auth))
                href="{{url('/')}}/login"
            @else
                href="{{url('/')}}/perfil"
            @endif
            >
                <img src="{{asset('images/account.png')}}" alt="" width="32px" height="32px">
                Conta
            </a>
        </div>
    </div>
</header>
