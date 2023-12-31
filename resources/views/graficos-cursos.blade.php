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
    @include('inc/header')
    <div class="area-site">
        <div class="breadcrumbs">
            <span> <a href="{{url('')}}" class="back-home">Home</a></span>
            <img src="{{asset('images/chavron-right.svg')}}" alt="" width="7px" height="10px">
            <span> <a href="{{url('')}}/cursos" class="back-home">Cursos</a></span>
            <img src="{{asset('images/chavron-right.svg')}}" alt="" width="7px" height="10px">
            <span>Graficos</span>
        </div>
        <div class="title-home">
            <h1 class="home-h1">Representação gráfica dos cursos</h1>
            <hr class="dotted-line">
        </div>
        <div class="area-egressos">
            <div class="select-course">
                <select>
                    @foreach ($dadosGraficos as $dadosGrafico)
                        <option name="curso" id="{{$dadosGrafico['cod_curso']}}" value="{{json_encode($dadosGrafico)}}" @if(isset($previous_curso) && $dadosGrafico['cod_curso'] == $previous_curso->codigo) selected @endif>{{$dadosGrafico['labels']}}</option>
                    @endforeach
                </select>
                <input type="hidden" id="previous-curso" data-previous-curso="@if(isset($previous_curso)){{ $previous_curso->codigo }} @endif">
            </div>
            <div class="chart-box">
                <canvas id="chart-1" class="lg-chart" data-dados-grafico="{{json_encode($primeiroGrafico)}}"></canvas>
                <canvas id="chart-2" class="lg-chart" data-dados-grafico="{{json_encode($primeiroGrafico)}}"></canvas>
                <canvas id="chart-3" class="lg-chart" data-dados-grafico="{{json_encode($primeiroGrafico)}}"></canvas>
            </div>
        </div>

    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'graficos';
</script>
</html>
