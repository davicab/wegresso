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

    public function index(){

        $allAlunos = $this->usuarios->getAlunos();
        $allCursos = $this->cursos->getCursos();

        $usariosPorCurso = $this->usuarios->getAlunosPorCurso();

        $arrCurso = [];
        $arrAluno = [];
        for($i = 0; $i < count($allCursos); $i ++){
            $arrCurso[$i] = $allCursos[$i]->descricao;
            if($usariosPorCurso[$i]){
                $arrAluno[$i] = $usariosPorCurso[$i]->total_alunos;
            }
        }

        $contagemPorAno = $this->usuarios->getAlunosAgrupadosPorAnoEgresso();

        $alunosEmpregados = $this->usuarios->getAlunosEmpregados();

        $alunosComputação = $this->usuarios->getAlunosComputacao();
        $alunosEletrica = $this->usuarios->getAlunosEletrica();
        $alunosCivil = $this->usuarios->getAlunosCivil();


        $alunosPorCursos = $this->cursos->getQuantidadeAlunoPorCurso();

        foreach ($alunosPorCursos as $result) {
            $ano_egresso = $result->ano_egresso;
            $curso_id = $result->id;
            $nomeCurso[$curso_id] = $result->descricao;
            $count = $result->count;

            if (!isset($dadosGraficoStack[$curso_id])) {
                $dadosGraficoStack[$curso_id] = [
                    'labels' => $nomeCurso[$curso_id],
                    'data' => [],
                ];
            }

            $dadosGraficoStack[$curso_id]['data'][$ano_egresso] = $count;
        }

        // Preencher os anos ausentes com '0' em cada curso
        foreach ($dadosGraficoStack as &$curso) {
            $primeiroAno = min(array_keys($curso['data']));
            $ultimoAno = max(array_keys($curso['data']));

            $intervaloAnos = range($primeiroAno, $ultimoAno);

            foreach ($intervaloAnos as $ano) {
                if (!isset($curso['data'][$ano])) {
                    $curso['data'][$ano] = 0;
                }
            }

            ksort($curso['data']);
        }

        $dadosGraficoPie = json_encode([
            'labels' => $arrCurso,
            'data' => $arrAluno
        ]);

        // $dadosGraficoStack = json_encode([
        //     'labels' => $arrCurso,
        //     'data' => $contagemGeralPorAno,
        // ]);

        // dd($arrCurso);

        // Converte os resultados em um formato que pode ser facilmente lido pelo JavaScript (JSON)
        $dadosGrafico = json_encode([
            'labels' => $contagemPorAno->pluck('ano_egresso')->toArray(),
            'data' => $contagemPorAno->pluck('count')->toArray(),
        ]);

        $dadosGraficoBars = json_encode([
            'labels' => $contagemPorAno->pluck('ano_egresso')->toArray(),
            'data' => $alunosEmpregados,
        ]);

        $this->dadosPagina['dadosGrafico'] = $dadosGrafico;
        $this->dadosPagina['dadosGraficoPie'] = $dadosGraficoPie;
        $this->dadosPagina['dadosGraficoStack'] = json_encode($dadosGraficoStack);
        $this->dadosPagina['dadosGraficoBars'] = $dadosGraficoBars;
        $this->dadosPagina['alunos'] = $allAlunos;
        $this->dadosPagina['cursos'] = Cursos::all();

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }
}
