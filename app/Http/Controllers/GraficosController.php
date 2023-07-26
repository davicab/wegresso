<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

class GraficosController extends Controller
{
    private $usuarios;
    private $dadosPagina;

    const VIEW = 'graficos-cursos';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
    }

    public function index(){

        $empregadosComp = $this->usuarios->getAlunosEmpregadosCurso(0);
        $empregadosEletr = $this->usuarios->getAlunosEmpregadosCurso(1);
        $empregadosCivil = $this->usuarios->getAlunosEmpregadosCurso(2);

        $alunosComp = $this->usuarios->getAlunosComputacao();
        $alunosEletr = $this->usuarios->getAlunosEletrica();
        $alunosCivil = $this->usuarios->getAlunosCivil();
        
        function calcularMediaFormatura($alunos) {
            $totalAlunos = count($alunos);
            $totalTempoFormatura = 0;
        
            foreach ($alunos as $aluno) {
                $tempoFormatura = $aluno->ano_egresso - $aluno->ano_ingresso;
                
                $totalTempoFormatura += $tempoFormatura;
            }
        
            $mediaTempoFormatura = $totalTempoFormatura / $totalAlunos;
        
            return number_format($mediaTempoFormatura, 1);
        }
        
        $mediaTempoComp = calcularMediaFormatura($alunosComp);
        $mediaTempoEletr = calcularMediaFormatura($alunosEletr);
        $mediaTempoCivil = calcularMediaFormatura($alunosCivil);

        $alunosGeral = $this->usuarios->getAlunosAgrupadosGeralPorAno();
        $dadosGraficoComp = [];
        $dadosGraficoEletr = [];
        $dadosGraficoCivil = [];
        
        foreach ($alunosGeral as $aluno) {
            $ano_egresso = $aluno->ano_egresso;
            $curso0 = $aluno->curso0;
            $curso1 = $aluno->curso1;
            $curso2 = $aluno->curso2;
        
            $dadosGraficoComp[] = [
                'ano_egresso' => $ano_egresso,
                'curso' => $curso0,
            ];
        
            $dadosGraficoEletr[] = [
                'ano_egresso' => $ano_egresso,
                'curso' => $curso1,
            ];
        
            $dadosGraficoCivil[] = [
                'ano_egresso' => $ano_egresso,
                'curso' => $curso2,
            ];
        }
        
        $dadosGraficoComp = json_encode([
            'labels' => ['Engenharia de Computação'],
            'data' => $dadosGraficoComp,
            'empregados' => $empregadosComp,
            'mediaFormatura' => $mediaTempoComp,
        ]);
        
        $dadosGraficoEletr = json_encode([
            'labels' => ['Engenharia Elétrica'],
            'data' => $dadosGraficoEletr,
            'empregados' => $empregadosEletr,
            'mediaFormatura' => $mediaTempoEletr,
        ]);
        
        $dadosGraficoCivil = json_encode([
            'labels' => ['Engenharia Civil'],
            'data' => $dadosGraficoCivil,
            'empregados' => $empregadosCivil,
            'mediaFormatura' => $mediaTempoCivil,
        ]);
        
        $this->dadosPagina['dadosGraficoComp'] = $dadosGraficoComp;
        $this->dadosPagina['dadosGraficoEletr'] = $dadosGraficoEletr;
        $this->dadosPagina['dadosGraficoCivil'] = $dadosGraficoCivil;

        return view(self::VIEW, $this->dadosPagina);
    }
    
}
