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

    public function index(){
        $cursos = $this->cursos->getCursos();
        $alunosEmpregados = [];

        $alunosPorCursos = $this->cursos->getQuantidadeAlunoPorCurso();

        $nomeCurso = [];
        $dadosGraficos = [];

        foreach ($cursos as $curso){
            $alunosEmpregados[$curso->id] = $this->usuarios->getAlunosEmpregadosCurso($curso->id);
        }
        // dd($alunosEmpregados);
        foreach ($alunosPorCursos as $result) {
            $ano_egresso = $result->ano_egresso;
            $curso_id = $result->id;
            $nomeCurso[$curso_id] = $result->descricao;
            $count = $result->count;

            if (!isset($dadosGraficos[$curso_id])) {
                $dadosGraficos[$curso_id] = [
                    'labels' => $nomeCurso[$curso_id],
                    'data' => [],
                    'empregados' =>[],
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

        $this->dadosPagina['dadosGraficos'] = $dadosGraficos;
        $this->dadosPagina['primeiroGrafico'] = reset($dadosGraficos);

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }

}
