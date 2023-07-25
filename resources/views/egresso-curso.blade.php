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
        <div class="title-home">
            <h1 class="home-h1">Egressos do curso {{$curso}}</h1>
            <hr class="dotted-line">
        </div>
        <div class="area-egressos">
            @foreach ($egressos as $egresso)
                <div class="single-egresso">
                    {{$egresso->name}}, {{$egresso->ano_egresso}}
                </div>
            @endforeach
        </div>
    </div>
    @include('inc/footer')
</body>
</html>
