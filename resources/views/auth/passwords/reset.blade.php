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
        <div class="card-body">

            <div class="custom-form">
                <h1>Alterar senha</h1>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <input id="email" type="email" placeholder="Email" class="custom-input" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <input id="password" type="password" placeholder="Nova senha" class="custom-input" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input id="password-confirm" type="password" placeholder="Confirme a senha" class="custom-input" name="password_confirmation" required autocomplete="new-password">
                        
                    <button type="submit" class="custom-submit-button">
                        {{ __('Trocar senha') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'reset'
</script>
</html>
