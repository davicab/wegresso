<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edicao de aluno</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('inc/header')
    <div class="area-site">
        <div class="breadcrumbs">
            <span> <a href="{{url('')}}" class="back-home">Home</a></span>
            <img src="{{asset('images/chavron-right.svg')}}" alt="" width="7px" height="10px">
            <span>Editar aluno : {{$infoUser->name}}</span>
        </div>
        <div class="title-home">
            <h1 class="home-h1">Editar aluno : {{$infoUser->name}}</h1>
            <hr class="dotted-line">
        </div>
        <div class="area-egressos">
            <form class="perfil-form" method="POST" action="{{ url('/') }}/edita-dados/{{$infoUser->id}}">
                @method('PUT')
                @csrf
                <div class="full-box">
                    <label for="name">Nome:</label>
                    <input class="form-control" type="text" maxlength="200" name="name" id="name" value="{{ $infoUser->name }}">
                </div>
                <div class="full-box">
                    <label for="email">Email:</label>
                    <input class="form-control" type="text" maxlength="200" name="email" id="email" value="{{ $infoUser->email }}">
                </div>
                <div class="full-box">
                    <label for="curso">Curso:</label>
                    <input class="form-control" type="text" maxlength="200" name="curso" id="curso" placeholder="{{ $cursoUser->descricao }}" readonly>
                </div>
                <div class="sm-box">
                    <label for="ano_egresso">Ano de Egresso:</label>
                    <input class="form-control" type="text" maxlength="4" name="ano_egresso" id="ano_egresso" value="{{ isset($infoUser->ano_egresso) ? $infoUser->ano_egresso : '' }}" placeholder="Ano de Egresso">
                </div>
                <div class="sm-box">
                    <label for="ano_ingresso">Ano de Ingresso:</label>
                    <input class="form-control" type="text" maxlength="4" name="ano_ingresso" id="ano_ingresso" value="{{ isset($infoUser->ano_ingresso) ? $infoUser->ano_ingresso : '' }}" placeholder="Ano de Ingresso">
                </div>
                <div class="full-box">
                    <label for="atual_emprego">Atual Emprego:</label>
                    <input class="form-control" type="text" maxlength="200" name="atual_emprego" id="atual_emprego" value="{{ isset($infoUser->atual_emprego) ? $infoUser->atual_emprego : '' }}" placeholder="Atual Emprego">
                </div>

                <div class="full-box">
                    <label for="experiencias">Experiências:</label>
                    <textarea class="form-control" name="experiencias" id="experiencias" maxlength="1000" placeholder="Experiências">{{ isset($infoUser->experiencias) ? $infoUser->experiencias : '' }}</textarea>
                </div>
                <button class="update-user" type="submit">Salvar</button>
            </form>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'curso';
</script>
</html>
