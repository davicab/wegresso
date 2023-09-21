<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listagem de egressos</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('inc/header')
    <div class="area-site">
        <div class="breadcrumbs">
            <span> <a href="{{url('')}}" class="back-home">Home</a></span>
            <img src="{{asset('images/chavron-right.svg')}}" alt="" width="7px" height="10px">
            <span> <a href="{{url('')}}/cursos" class="back-home">Lista de cursos</a></span>
            <img src="{{asset('images/chavron-right.svg')}}" alt="" width="7px" height="10px">
            <span>Listagem de egressos do curso {{$curso->descricao}}</span>
        </div>
        <div class="title-home">
            <h1 class="home-h1">Egressos do curso {{$curso->descricao}}</h1>
            <hr class="dotted-line">
        </div>
        <div class="area-egressos">
            @foreach($egressos as $aluno)
                <div class="aluno-item">
                    @if(isset($can_edit) && $can_edit == true)
                        <a href="{{url('')}}/editar-aluno/{{$aluno->id}}" class="aluno-info">Nome: {{$aluno->name}}, Egresso em : {{$aluno->ano_egresso}}</a>
                    @else
                        <div class="aluno-info">Nome: {{$aluno->name}}, Egresso em : {{$aluno->ano_egresso}}</div>
                    @endif
                </div>
            @endforeach
        </div>

        <a href="{{url('/')}}/cursos/graficos?curso={{$cod_curso}}" class="generate-graph">
            <span>Representação gráfica</span>
            <img class="animation-hand" src="{{asset('/images/HandPointing.svg')}}" alt="mão clicando" width="25px" height="25px">
        </a>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'curso';
</script>
</html>
