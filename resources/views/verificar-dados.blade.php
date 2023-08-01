<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Painel</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    {{-- @include('inc/header') --}}
    <div class="area-site">
        <div class="title-home">
            <h1 class="home-h1">Painel de administração</h1>
            <hr class="dotted-line">
        </div>
        <div class="form-box">
            @if(!$nao_verificados->isNotEmpty())
                <span>Sem dados de usuários para serem validados</span>
            @else
                @foreach($nao_verificados as $aluno)
                    <a class="single-user" id="{{$aluno->id}}" href="{{url('/')}}/validar-egresso/{{$aluno->id}}">{{$aluno->name}}
                @endforeach
            @endif
            {{-- {{$nao_verificados}} --}}
        </div>
        {{-- {{dd($curso , $empregado, $ano_egresso, $ano_ingresso)}} --}}
    </div>
    {{-- @include('inc/footer') --}}
</body>
<script>
    var page = 'verificar';
</script>
</html>
