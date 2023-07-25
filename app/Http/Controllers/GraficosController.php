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

        $this->dadosPagina['qtd'] = $this->usuarios->getAlunosComputacao();

        $empregadosComp = $this->usuarios->getAlunosEmpregadosCurso(0);
        $empregadosEletr = $this->usuarios->getAlunosEmpregadosCurso(1);
        $empregadosCivil = $this->usuarios->getAlunosEmpregadosCurso(2);

        $alunosComp = $this->usuarios->getAlunosComputacao();

        $dadosGraficoComp = json_encode([
            'labels' => ['Engenharia de Computação'],
            'data' => $alunosComp
        ]);


        // $dadosGrafico = json_encode([
        //     'labels' => $contagemAlunosCurso->pluck('ano_egresso')->toArray(),
        //     'data' => $contagemAlunosCurso->pluck('count')->toArray(),
        // ]);
        
        $this->dadosPagina['dadosGrafico'] = $alunosComp;


        return view(self::VIEW, $this->dadosPagina);
    }
    
}
