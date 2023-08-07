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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <strong>Link de redefinição de senha enviado!</strong>
                        </div>
                    @endif
                    <div class="custom-form">
                        <h1>Redefinição de senha</h1>
                        <h2>Preencha o campo abaixo para receber o link de confirmação</h2>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <input id="email" placeholder="email" type="email" class="custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>


                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Email não encontrado nos nossos registros.</strong>
                                </span>
                            @enderror

                            <button type="submit" class="custom-submit-button">
                                {{ __('Enviar link de redefinição de senha') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'send-email'
</script>
</html>
