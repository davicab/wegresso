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

    public function index(Request $request){
        $cursos = $this->cursos->getCursos();
        $previousCurso = $request->curso;
        $alunosEmpregados = [];

        if(!is_null($request->curso)){
            $previous_curso = $this->cursos->getCursoByCodigo($previousCurso);
            $this->dadosPagina['previous_curso'] = $previous_curso;
        }

        $alunosPorCursos = $this->cursos->getQuantidadeAlunoPorCurso();

        $nomeCurso = [];
        $dadosGraficos = [];


        $usuarios = $this->usuarios->getAllAlunos();

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
            $media = $dados['soma'] / $dados['quantidade'];
            $mediaFinal[$cursoId] = round($media, 1);
        }

        foreach ($cursos as $curso){
            $alunosEmpregados[$curso->id] = $this->usuarios->getAlunosEmpregadosCurso($curso->id);
        }

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

        // Preencher os anos ausentes com '0' em cada curso
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

        $this->dadosPagina['dadosGraficos'] = $dadosGraficos;
        if(!is_null($request->curso)){
            $this->dadosPagina['primeiroGrafico'] = $dadosGraficos[$previous_curso->id];
        }else{
            $this->dadosPagina['primeiroGrafico'] = reset($dadosGraficos);
        }

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }

}
