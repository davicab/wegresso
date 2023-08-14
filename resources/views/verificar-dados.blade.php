<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Painel</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('inc/header')
    <div class="area-site">
        <div class="title-home">
            <h1 class="home-h1">Painel de administração</h1>
            <hr class="dotted-line">
        </div>
        <div class="form-box">
            @if(!$nao_verificados->isNotEmpty())
                <span>Sem dados de usuários para serem validados</span>
            @else
                @foreach($nao_verificados as $aluno)
                    <a class="single-user" id="{{$aluno->id}}" href="{{url('/')}}/validar-egresso/{{$aluno->id}}">{{$aluno->name}}
                @endforeach
            @endif
        </div>
        <div class="form-box">
            <h2>Cursos da instituição: </h2>
            @if(isset($cursos) && $cursos->isNotEmpty())
                @foreach($cursos as $curso)
                <span>{{$curso->descricao}}</span>
                <br>
                @endforeach
            @endif
            <h3>Criação de novos cursos: </h3>
            <form method="POST" action="{{ url('/') }}/create-curso" class="perfil-form">
                @method('PUT')
                @csrf
                <div class="full-box">
                    <label for="nome">Nome do curso:</label>
                    <input class="form-control" type="text" maxlength="200" name="nome" id="nome" value="{{ isset($nome) ? $nome : '' }}" placeholder="Nome do curso">
                </div>
                <div class="full-box">
                    <label for="descricao">Descrição do curso:</label>
                    <textarea class="form-control" name="descricao" id="descricao" maxlength="1000" placeholder="Decrição">{{ isset($descricao) ? $descricao : '' }}</textarea>
                </div>
                <button class="update-user" type="submit">Salvar</button>
            </form>
        </div>
        <div class="form-box">
            <h2>Egressos da instituição: </h2>
            <form method="POST" action="{{ url('/') }}/import-data" class="perfil-form">
                @method('PUT')
                @csrf
                <div class="full-box">
                    <label for="question">Importar usuarios do arquivo importado ?</label>
                    <select class="form-control" name="question" id="question" required>
                        <option value="1" {{ isset($question) && $question == 1 ? 'selected' : '' }}>Sim</option>
                        <option value="0" {{ isset($question) && $question == 0 ? 'selected' : '' }}>Não</option>
                    </select>
                </div>
                <button class="update-user" type="submit">Salvar</button>
            </form>
        </div>
        {{-- {{dd($curso , $empregado, $ano_egresso, $ano_ingresso)}} --}}
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'verificar-dados';
</script>
</html>
