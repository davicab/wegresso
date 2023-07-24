<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('inc/header')
    <div class="area-site">
        @php
            $dadosGraficoJSON = json_encode($dadosGrafico);
        @endphp
        <canvas id="chart" class="lg-chart" data-dados-grafico="{{ $dadosGraficoJSON }}"></canvas>
    </div>
    @include('inc/footer')
</body>
</html>
