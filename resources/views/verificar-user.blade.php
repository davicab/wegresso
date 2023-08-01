<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verificar</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    {{-- @include('inc/header') --}}
    <div class="area-site">
        <div class="title-home">
            <h1 class="home-h1">Verificação de dados de {{$infoUser->name}}</h1>
            <hr class="dotted-line">
        </div>
        {{-- {{dd($infoUser)}} --}}
        <form class="perfil-form" method="POST" action="{{ url('/') }}/validar-dados/{{$infoUser->id}}">
            @method('PUT')
            @csrf 
            <div class="full-box">
                <label for="atual_emprego">Atual Emprego:</label>
                <input class="form-control" type="text" maxlength="200" name="atual_emprego" id="atual_emprego" value="{{ isset($infoUser->atual_emprego) ? $infoUser->atual_emprego : '' }}" placeholder="Atual Emprego" readonly>
            </div>

            <div class="full-box">
                <label for="experiencias">Experiências:</label>
                <textarea class="form-control" name="experiencias" id="experiencias" maxlength="1000" readonly placeholder="Experiências">{{ isset($infoUser->experiencias) ? $infoUser->experiencias : '' }}</textarea>
            </div>
            <div class="full-box">
                <label for="status">Validar dados?</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" {{ isset($infoUser->status) && $infoUser->status == 1 ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ isset($infoUser->status) && $infoUser->status == 0 ? 'selected' : '' }}>Não</option>
                </select>
            </div>
            <button class="update-user" type="submit">Salvar</button>
        </form>
        {{-- {{dd($curso , $empregado, $ano_egresso, $ano_ingresso)}} --}}
    </div>
    {{-- @include('inc/footer') --}}
</body>
<script>
    var page = 'verificar';
</script>
</html>
