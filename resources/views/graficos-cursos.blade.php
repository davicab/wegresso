<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Egressos do curso </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    {{-- @include('inc/header') --}}
    <div class="area-site">
        {{dd($dadosGrafico)}}
        <div class="title-home">
            <h1 class="home-h1">Egressos do curso </h1>
            <hr class="dotted-line">
        </div>

    </div>
    {{-- @include('inc/footer') --}}
</body>
<script>
    var page = 'graficos';
</script>
</html>
