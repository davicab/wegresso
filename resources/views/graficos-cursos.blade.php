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
        <div class="breadcrumbs">
            <span> <a href="{{url('')}}" class="back-home">Home</a></span>
            <img src="{{asset('images/chavron-right.svg')}}" alt="" width="7px" height="10px">
            <span>Graficos</span>
        </div>
        <div class="title-home">
            <h1 class="home-h1">Egressos do curso </h1>
            <hr class="dotted-line">
        </div>
        {{-- {{dd($dadosGraficos)}} --}}
        <div class="area-egressos">
            <div class="select-course">
                @foreach ($dadosGraficos as $dadosGrafico)
                    <label class="label-container">
                        <input type="checkbox" name="curso" value="{{json_encode($dadosGrafico)}}" @if($loop->iteration == 1) checked @endif> {{$dadosGrafico['labels']}}
                        <span class="checkmark"></span>
                    </label>
                @endforeach
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
