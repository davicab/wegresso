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
            <span>Todos os cursos</span>
        </div>
        <div class="title-home">
            <h1 class="home-h1">Todos os cursos</h1>
            <hr class="dotted-line">
        </div>
        <div class="area-egressos">
            @foreach($cursos as $curso)
                <a class="curso-link" href="{{url('/')}}/cursos/{{$slug[$curso->id]}}/{{$curso->codigo}}">{{$curso->descricao}}</a>
            @endforeach
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'curso';
</script>
</html>
