<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perfil</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('inc/header')
    <div class="area-site">
        <div class="title-home">
            <h1 class="home-h1">Perfil - @if(isset($name)){{$name}} @endif</h1>
            <hr class="dotted-line">
        </div>
        <div class="form-box">
            @if(isset($user) && $user == 'aluno')
                <form class="perfil-form" method="POST" action="{{ url('/') }}/salvar-perfil/{{$id}}">
                    @method('PUT')
                    @csrf 
                    <div class="half-box">
                        <label for="curso">Curso:</label>
                        <input class="form-control" type="text" maxlength="200" name="curso" id="curso" value="{{ isset($curso) ? $curso : '' }}" placeholder="Curso" readonly>
                    </div>
                    <div class="sm-box">
                        <label for="ano_egresso">Ano de Egresso:</label>
                        <input class="form-control" type="text" maxlength="4" name="ano_egresso" id="ano_egresso" value="{{ isset($ano_egresso) ? $ano_egresso : '' }}" placeholder="Ano de Egresso" readonly>
                    </div>
                    <div class="sm-box">
                        <label for="ano_ingresso">Ano de Ingresso:</label>
                        <input class="form-control" type="text" maxlength="4" name="ano_ingresso" id="ano_ingresso" value="{{ isset($ano_ingresso) ? $ano_ingresso : '' }}" placeholder="Ano de Ingresso" readonly>
                    </div>

                    <div class="half-box">
                        <label for="empregado">Empregado:</label>
                        <select class="form-control" name="empregado" id="empregado">
                            <option value="1" {{ isset($empregado) && $empregado == 1 ? 'selected' : '' }}>Sim</option>
                            <option value="0" {{ isset($empregado) && $empregado == 0 ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                    <div class="half-box">
                        <label for="permite_dados">Permite o uso dos seus dados para estatistica do site ?</label>
                        <select class="form-control" name="permite_dados" id="permite_dados" required>
                            <option value="1" {{ isset($permite_dados) && $permite_dados == 1 ? 'selected' : '' }}>Sim</option>
                            <option value="0" {{ isset($permite_dados) && $permite_dados == 0 ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                    <div class="full-box">
                        <label for="atual_emprego">Atual Emprego:</label>
                        <input class="form-control" type="text" maxlength="200" name="atual_emprego" id="atual_emprego" value="{{ isset($atual_emprego) ? $atual_emprego : '' }}" placeholder="Atual Emprego">
                    </div>
                    <div class="full-box">
                        <label for="experiencias">Experiências:</label>
                        <textarea class="form-control" name="experiencias" id="experiencias" maxlength="1000" placeholder="Experiências">{{ isset($experiencias) ? $experiencias : '' }}</textarea>
                    </div>
                
                    <button class="update-user" type="submit">Salvar</button>
                </form>
            @endif
        </div>
        {{-- {{dd($curso , $empregado, $ano_egresso, $ano_ingresso)}} --}}
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'perfil';
</script>
</html>
