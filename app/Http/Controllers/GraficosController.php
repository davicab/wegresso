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

    const VIEW = 'graficos-cursos';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
    }

    public function index(){

        $empregadosComp = $this->usuarios->getAlunosEmpregadosCurso(1);
        $empregadosEletr = $this->usuarios->getAlunosEmpregadosCurso(2);
        $empregadosCivil = $this->usuarios->getAlunosEmpregadosCurso(3);

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
        
        $alunosPorCursos = Cursos::getQuantidadeAlunoPorCurso();
        $nomeCurso = [];
        $dadosGraficos = [];
        
        foreach ($alunosPorCursos as $result) {
            $ano_egresso = $result->ano_egresso;
            $curso_id = $result->id;
            $nomeCurso[$curso_id] = $result->descricao;
            $count = $result->count;
        
            if (!isset($dadosGraficos[$curso_id])) {
                $dadosGraficos[$curso_id] = [
                    'labels' => $nomeCurso[$curso_id],
                    'data' => [],
                ];
            }
        
            $dadosGraficos[$curso_id]['data'][] = [
                'ano_egresso' => $ano_egresso,
                'quantidade' => $count,
            ];
        }
        
        // Montar os dados para a view
        $dadosParaView = [
            'dadosGraficos' => $dadosGraficos,
        ];
        
        
        $dadosGraficoComp = json_encode([
            'labels' => ['Engenharia de Computação'],
            // 'data' => $dadosGraficoComp,
            'empregados' => $empregadosComp,
            'mediaFormatura' => $mediaTempoComp,
        ]);
        
        $dadosGraficoEletr = json_encode([
            'labels' => ['Engenharia Elétrica'],
            // 'data' => $dadosGraficoEletr,
            'empregados' => $empregadosEletr,
            'mediaFormatura' => $mediaTempoEletr,
        ]);
        
        $dadosGraficoCivil = json_encode([
            'labels' => ['Engenharia Civil'],
            // 'data' => $dadosGraficoCivil,
            'empregados' => $empregadosCivil,
            'mediaFormatura' => $mediaTempoCivil,
        ]);
        
        $this->dadosPagina['dadosGrafico'] = $dadosParaView;
        $this->dadosPagina['dadosGraficoEletr'] = $dadosGraficoEletr;
        $this->dadosPagina['dadosGraficoCivil'] = $dadosGraficoCivil;

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }
    
}
