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
                    <h1>Registrar usuario</h1>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <input id="name" type="text" class="custom-input @error('name') is-invalid @enderror" name="name" placeholder="Nome" value="{{ old('name') }}" required autocomplete="name" autofocus>

        
                	 <input id="email" type="email" class="custom-input @error('email') is-invalid @enderror" placeholder="Email (pessoal)" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>Email não encontrado nos nossos registros.</strong>
                            </span>
                        @enderror
            
                        <input id="password" type="password" class="custom-input @error('password') is-invalid @enderror" placeholder="Senha" name="password" required autocomplete="new-password">
                        <input id="password-confirm" type="password" class="custom-input" name="password_confirmation" placeholder="Repita a senha" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>Senha incorreta</strong>
                            </span>
                        @enderror
            
                        <button type="submit" class="custom-submit-button">
                            {{ __('Registrar') }}
                        </button>
            
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'register'
</script>
</html>
