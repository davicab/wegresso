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
        <div class="title-home">
            <h1 class="home-h1">Relatório consolidado de cursos</h1>
            <hr class="dotted-line">
        </div>
        <div class="first-block">
            <div class="chart-block">
                <span>Todos os egressos</span>
                <canvas id="chart-1" class="lg-chart" data-dados-grafico="{{ $dadosGrafico }}"></canvas>
            </div>
            <div class="chart-block">
                <span>Egressos por curso</span>
                <canvas id="chart-2" class="lg-chart" data-dados-grafico="{{ $dadosGraficoPie }}"></canvas>
            </div>
        </div>
        <div class="title-home">
            <h2 class="home-h1">Acesse a lista de egressos por curso</h2>
            <hr class="dotted-line">
        </div>
        <div class="second-block">
            <div class="courses-view">
                <span class="top-courses">Cursos Disponíveis</span>
                <a class="single-course" href="{{url('/')}}/cursos">
                    <span class="course-span">Acesse todos os cursos os IF aqui!</span>
                    <img src="{{asset('images/logo_trindade.png')}}" alt="" width="114px" height="206px">
                </a>
            </div>
        </div>
        <div class="third-block">
            <div class="chart-block">
                <span>Egressos por curso, a cada ano</span>
                <canvas id="chart-3" class="lg-chart" data-dados-grafico="{{ $dadosGraficoStack }}"></canvas>
            </div>
            <div class="chart-block">
                <span>Egressos alocados no mercado de trabalho</span>
                <canvas id="chart-4" class="lg-chart" data-dados-grafico="{{ $dadosGraficoBars }}"></canvas>
            </div>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'home'
</script>
</html>
