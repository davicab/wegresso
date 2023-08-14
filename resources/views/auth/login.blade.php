<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wegresso</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('inc/header')
    <div class="area-site">
        <div class="card">
            <div class="card-body">
                <div class="custom-form">
                    <h1>Login</h1>
                    <h2>Acesse o WEgresso com suas credenciais</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
        
                        <input id="email" type="email" class="custom-input @error('email') is-invalid @enderror" placeholder="Email (pessoal)" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>Email não encontrado nos nossos registros.</strong>
                            </span>
                        @enderror
            
                        <input id="password" type="password" class="custom-input @error('password') is-invalid @enderror" placeholder="Senha" name="password" required autocomplete="current-password">
            
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>Senha incorreta</strong>
                            </span>
                        @enderror
            
                        <div class="custom-checkbox">
                            <input class="custom-checkbox-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-checkbox-label" for="remember">
                                {{ __('Lembrar acesso') }}
                            </label>
                        </div>
            
                        <button type="submit" class="custom-submit-button">
                            {{ __('Login') }}
                        </button>
            
                        @if (Route::has('password.request'))
                            <a class="custom-link" href="{{ route('password.request') }}">
                                {{ __('Esqueceu sua senha ou é seu primeiro acesso?') }}
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'login'
</script>
</html>
