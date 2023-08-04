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

        $countCurso = count($allCursos);

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

        $contagemGeralPorAno = $this->usuarios->getAlunosAgrupadosGeralPorAno();

        // dd($contagemGeralPorAno);

        $alunosEmpregados = $this->usuarios->getAlunosEmpregados();

        $alunosComputação = $this->usuarios->getAlunosComputacao();
        $alunosEletrica = $this->usuarios->getAlunosEletrica();
        $alunosCivil = $this->usuarios->getAlunosCivil();

        $dadosGraficoPie = json_encode([
            'labels' => $arrCurso,
            'data' => $arrAluno
        ]);

        $dadosGraficoStack = json_encode([
            'labels' => $arrCurso,
            'data' => $contagemGeralPorAno,
        ]);

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
        $this->dadosPagina['dadosGraficoStack'] = $dadosGraficoStack;
        $this->dadosPagina['dadosGraficoBars'] = $dadosGraficoBars;
        $this->dadosPagina['alunos'] = $allAlunos;
        $this->dadosPagina['cursos'] = Cursos::all();

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }
}
