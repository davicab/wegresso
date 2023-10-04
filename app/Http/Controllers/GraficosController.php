<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;

class GraficosController extends Controller
{
    private $usuarios;
    private $dadosPagina;
    private $cursos;

    const VIEW = 'graficos-cursos';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->cursos = new Cursos();
        $this->dadosPagina = array();
    }

    /**
     * Exibe a página de gráficos de cursos.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        // Obtém a lista de cursos
        $cursos = $this->cursos->getCursos();
        $previousCurso = $request->curso;
        $alunosEmpregados = [];

        // Verifica se um curso anterior foi selecionado
        if(!is_null($request->curso)){
            $previous_curso = $this->cursos->getCursoByCodigo($previousCurso);
            $this->dadosPagina['previous_curso'] = $previous_curso;
        }

        // Obtém a quantidade de alunos por curso
        $alunosPorCursos = $this->cursos->getQuantidadeAlunoPorCurso();

        $nomeCurso = [];
        $dadosGraficos = [];

        // Obtém todos os alunos
        $usuarios = $this->usuarios->getAllAlunos();
        
        // Calcula a media de tempo de conclusão de cada curso
        $mediaFinal = $this->generateMedia($usuarios);

        // Obtém o número de alunos empregados por curso
        foreach ($cursos as $curso){
            $alunosEmpregados[$curso->id] = $this->usuarios->getAlunosEmpregadosCurso($curso->id);
        }

        // Prepara os dados para gráficos
        foreach ($alunosPorCursos as $result) {
            $ano_egresso = $result->ano_egresso;
            $curso_id = $result->id;
            $nomeCurso[$curso_id] = $result->descricao;
            $count = $result->count;
            $codigo_curso = $result->codigo;

            if (!isset($dadosGraficos[$curso_id])) {
                $dadosGraficos[$curso_id] = [
                    'cod_curso' => $codigo_curso,
                    'labels' => $nomeCurso[$curso_id],
                    'data' => [],
                    'empregados' =>[],
                    'media' => $mediaFinal[$curso_id]
                ];
            }

            $dadosGraficos[$curso_id]['data'][$ano_egresso] = $count;
        }

        // Preenche anos ausentes com '0' em cada curso
        foreach ($dadosGraficos as &$curso) {
            $primeiroAno = min(array_keys($curso['data']));
            $ultimoAno = max(array_keys($curso['data']));

            $intervaloAnos = range($primeiroAno, $ultimoAno);

            foreach ($intervaloAnos as $ano) {
                if (!isset($curso['data'][$ano])) {
                    $curso['data'][$ano] = 0;
                }

                // Inicializa empregados como 0 para cada ano
                $curso['empregados'][$ano] = 0;
            }

            ksort($curso['data']);
        }

        // Associa o número de alunos empregados por ano e curso
        foreach ($dadosGraficos as $curso_id => &$curso) {
            foreach ($alunosEmpregados[$curso_id] as $aluno) {
                $ano_egresso = $aluno->ano_egresso;
                $empregados = (int) $aluno->empregados;

                if (isset($curso['empregados'][$ano_egresso])) {
                    $curso['empregados'][$ano_egresso] = $empregados;
                }
            }
        }
        ksort($dadosGraficos);

        dd($dadosGraficos);

        // Define os dados para a view
        $this->dadosPagina['dadosGraficos'] = $dadosGraficos;

        // Seleciona qual curso será o primeiro carregado na pagina
        if(!is_null($request->curso)){
            $this->dadosPagina['primeiroGrafico'] = $dadosGraficos[$previous_curso->id];
        }else{
            $this->dadosPagina['primeiroGrafico'] = reset($dadosGraficos);
        }

        $this->dadosPagina['auth'] = Auth::check();

        // Exibe a view dos gráficos de cursos
        return view(self::VIEW, $this->dadosPagina);
    }

    public function generateMedia($usuarios){
        $mediaPorCurso = [];
    
        foreach ($usuarios as $usuario) {
            $cursoId = $usuario->curso_id;
            $diferenca = ($usuario->ano_egresso - $usuario->ano_ingresso) + 1;
    
            if (!isset($mediaPorCurso[$cursoId])) {
                $mediaPorCurso[$cursoId] = [
                    'soma' => 0,
                    'quantidade' => 0,
                ];
            }
    
            $mediaPorCurso[$cursoId]['soma'] += $diferenca;
            $mediaPorCurso[$cursoId]['quantidade']++;
        }
    
        $mediaFinal = [];
    
        foreach ($mediaPorCurso as $cursoId => $dados) {
            $media = round($dados['soma'] / $dados['quantidade'], 1);
            $mediaFinal[$cursoId] = $media;
        }
    
        return $mediaFinal;
    }
}
