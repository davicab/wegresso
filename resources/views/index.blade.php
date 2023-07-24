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
        <div class="first-block">
            <div class="title-home">
                <h1 class="home-h1">Relatório consolidado de cursos</h1>
                <hr class="dotted-line">
            </div>
            <canvas id="chart-1" class="lg-chart" data-dados-grafico="{{ $dadosGrafico }}"></canvas>
            <canvas id="chart-2" class="lg-chart" data-dados-grafico="{{ $dadosGraficoPie }}"></canvas>
        </div>
        <div class="second-block">
            <div class="courses-view">
                <span class="top-courses">Cursos Disponíveis</span>
                <div class="single-course"></div>
                <div class="single-course"></div>
                <div class="single-course"></div>
            </div>
        </div>
    </div>
    @include('inc/footer')
</body>
</html>
