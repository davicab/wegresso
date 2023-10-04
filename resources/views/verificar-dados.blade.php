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
        <div class="verificar-alunos">
            @if(!$nao_verificados->isNotEmpty())
                <span>Sem dados de usuários para serem validados</span>
            @else
                <h2>Alunos com dados a serem verificados: </h2>
                <div class="alunos-box">
                    @foreach($nao_verificados as $aluno)
                        <div class="aluno-item">
                            <a class="single-user" id="{{$aluno->id}}" href="{{url('/')}}/validar-egresso/{{$aluno->id}}">{{$aluno->name}}</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="form-box">
            <h2>Cursos da instituição: </h2>
            @if(isset($cursos) && $cursos->isNotEmpty())
                <div class="alunos-box">
                    @foreach($cursos as $curso)
                        <div class="aluno-item">
                            <span>{{$curso->descricao}}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="form-box">
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
            <h2>Importação de alunos e cursos: </h2>
            <form class="import-form" action="/receive-csv" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf 
                <label for="arquivo" class="form-label">Selecione um arquivo CSV - APENAS CSV:</label>
                <input type="file" name="arquivo" id="arquivo" class="file-input" accept=".csv" required>
                <button type="submit" class="update-user">Enviar Arquivo</button>
            </form>
        </div>
    </div>
    @include('inc/footer')
</body>
<script>
    var page = 'verificar-dados';
</script>
</html>
