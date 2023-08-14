<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $usuarios;
    private $dadosPagina;
    private $cursos;

    const VIEW = 'index';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->cursos = new Cursos();
        $this->dadosPagina = array();
    }

    public function index()
    {
        // Obtém todos os alunos
        $allAlunos = $this->usuarios->getAlunos();
    
        // Obtém todos os cursos
        $allCursos = $this->cursos->getCursos();
    
        // Obtém a contagem de alunos por curso
        $usariosPorCurso = $this->usuarios->getAlunosPorCurso();
    
        // Inicializa arrays para armazenar dados de cursos e alunos
        $arrCurso = [];
        $arrAluno = [];
    
        // Preenche os arrays de cursos e alunos
        for ($i = 0; $i < count($allCursos); $i++) {
            $arrCurso[$i] = $allCursos[$i]->descricao;
    
            if ($usariosPorCurso[$i]) {
                $arrAluno[$i] = $usariosPorCurso[$i]->total_alunos;
            }
        }
    
        // Obtém a contagem de alunos agrupados por ano de egresso
        $contagemPorAno = $this->usuarios->getAlunosAgrupadosPorAnoEgresso();
    
        // Obtém a contagem de alunos empregados por ano de egresso
        $alunosEmpregados = $this->usuarios->getAlunosEmpregados();
    
        // Obtém a quantidade de alunos por curso
        $alunosPorCursos = $this->cursos->getQuantidadeAlunoPorCurso();
    
        // Inicializa um array para armazenar dados de gráfico de barra empilhada
        $dadosGraficoStack = [];
    
        // Preenche o array de gráfico de barra empilhada com dados de alunos por curso e ano de egresso
        foreach ($alunosPorCursos as $result) {
            $ano_egresso = $result->ano_egresso; //seleciona o ano em que o aluno se torna um egresso
            $curso_id = $result->id; //seleciona o id do curso
            $nomeCurso[$curso_id] = $result->descricao; //seleciona o nome do curso com base no id
            $count = $result->count; // conta a quantidade de ocorrencia de alunos
    
            if (!isset($dadosGraficoStack[$curso_id])) { //garante que os dados do curso sejam inicializados apenas uma vez
                $dadosGraficoStack[$curso_id] = [ // estrutura o array do grafico de barra empilhada
                    'labels' => $nomeCurso[$curso_id],
                    'data' => [],
                ];
            }
    
            $dadosGraficoStack[$curso_id]['data'][$ano_egresso] = $count;
        }
    
        // Preenche os anos ausentes com '0' em cada curso para o gráfico de barra empilhada
        foreach ($dadosGraficoStack as &$curso) {
            $primeiroAno = min(array_keys($curso['data'])); //selciona o primeiro ano da lista de datas
            $ultimoAno = max(array_keys($curso['data']));//selciona o ultimo ano da lista de datas
    
            $intervaloAnos = range($primeiroAno, $ultimoAno); // calcula o intervalo
    
            foreach ($intervaloAnos as $ano) { // insere valor 0 para cada ano que não existia na lista original
                if (!isset($curso['data'][$ano])) {
                    $curso['data'][$ano] = 0;
                }
            }
    
            ksort($curso['data']); //ordena de forma crescente a lista de datas
        }
    
        // Converte os arrays de dados em formato JSON para serem usados em gráficos no JavaScript
        $dadosGraficoPie = json_encode([
            'labels' => $arrCurso,
            'data' => $arrAluno,
        ]);
    
        $dadosGrafico = json_encode([
            'labels' => $contagemPorAno->pluck('ano_egresso')->toArray(),
            'data' => $contagemPorAno->pluck('count')->toArray(),
        ]);
    
        $dadosGraficoBars = json_encode([
            'labels' => $contagemPorAno->pluck('ano_egresso')->toArray(),
            'data' => $alunosEmpregados,
        ]);
    
        // Prepara os dados para a página de visualização e carrega a view correspondente
        $this->dadosPagina['dadosGrafico'] = $dadosGrafico;
        $this->dadosPagina['dadosGraficoPie'] = $dadosGraficoPie;
        $this->dadosPagina['dadosGraficoStack'] = json_encode($dadosGraficoStack);
        $this->dadosPagina['dadosGraficoBars'] = $dadosGraficoBars;
        $this->dadosPagina['alunos'] = $allAlunos;
        $this->dadosPagina['cursos'] = Cursos::all();
        $this->dadosPagina['auth'] = Auth::check();
    
        // Retorna a view renderizada com os dados preparados
        return view(self::VIEW, $this->dadosPagina);
    }
}
