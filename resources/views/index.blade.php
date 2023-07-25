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
        {{-- {{dd($dadosGraficoBars)}} --}}
        <div class="title-home">
            <h1 class="home-h1">Relatório consolidado de cursos</h1>
            <hr class="dotted-line">
        </div>
        <div class="first-block">
            <canvas id="chart-1" class="lg-chart" data-dados-grafico="{{ $dadosGrafico }}"></canvas>
            <canvas id="chart-2" class="lg-chart" data-dados-grafico="{{ $dadosGraficoPie }}"></canvas>
        </div>
        <div class="title-home">
            <h2 class="home-h1">Acesse a lista de egressos por curso</h2>
            <hr class="dotted-line">
        </div>
        <div class="second-block">
            <div class="courses-view">
                <span class="top-courses">Cursos Disponíveis</span>
                <a class="single-course" href="{{url('/')}}/computacao">
                    <span class="course-span">Engenharia de Computação</span>
                    <img src="{{asset('images/pc.png')}}" alt="" width="120px" height="120px">
                </a>
                <a class="single-course" href="{{url('/')}}/eletrica">
                    <span class="course-span">Engenharia Elétrica</span>
                    <img src="{{asset('images/Gear.png')}}" alt="" width="120px" height="120px">
                </a>
                <a class="single-course" href="{{url('/')}}/civil">
                    <span class="course-span">Engenharia Civil</span>
                    <img src="{{asset('images/civil.png')}}" alt="" width="120px" height="120px">
                </a>
            </div>
        </div>
        <div class="third-block">
            <canvas id="chart-3" class="lg-chart" data-dados-grafico="{{ $dadosGraficoStack }}"></canvas>
            <canvas id="chart-4" class="lg-chart" data-dados-grafico="{{ $dadosGraficoBars }}"></canvas>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'home'
</script>
</html>
