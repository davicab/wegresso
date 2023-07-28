<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Egressos do curso {{$curso}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('inc/header')
    <div class="area-site">
        <div class="breadcrumbs">
            <span> <a href="{{url('')}}" class="back-home">Home</a></span>
            <img src="{{asset('images/chavron-right.svg')}}" alt="" width="7px" height="10px">
            <span>{{$curso}}</span>
        </div>
        <div class="title-home">
            <h1 class="home-h1">Egressos do curso {{$curso}}</h1>
            <hr class="dotted-line">
        </div>
        <div class="area-egressos">
            @foreach ($egressos as $egresso)
                <div id="lista-usuarios" class="single-egresso">
                    <span class="egresso-name">{{$egresso->name}}</span>
                    <span class="egress-year">egresso em: {{$egresso->ano_egresso}}</span>
                    @if(isset($highUser) && $highUser == true)
                        <span class="egresso-more"> . . . </span>
                    @endif
                </div>
            @endforeach
            <a href="{{url('/')}}/cursos/graficos" class="generate-graph">
                <span>Representação gráfica</span>
                <img class="animation-hand" src="{{asset('/images/HandPointing.svg')}}" alt="mão clicando" width="25px" height="25px">
            </a>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'curso';
</script>
</html>
