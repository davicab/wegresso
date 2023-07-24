<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

class HomeController extends Controller
{
    private $usuarios;
    private $dadosPagina;

    const VIEW = 'index';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
    }

    public function index(){

        $contagemPorAno = $this->usuarios->getAlunosAgrupadosPorAnoEgresso();

        $contagemPorCursoPorAno = $this->usuarios->getAlunosAgrupadosPorCursoPorAno();

        $alunosEmpregados = $this->usuarios->getAlunosEmpregados();

        $alunosComputação = $this->usuarios->getAlunosComputacao();
        $alunosEletrica = $this->usuarios->getAlunosEletrica();
        $alunosCivil = $this->usuarios->getAlunosCivil();

        $this->dadosPagina['test'] = $this->usuarios->getAlunosEmpregados();

        $dadosGraficoPie = json_encode([
            'labels' => ['Engenharia de Computação', 'Engenharia Elétrica', 'Engenharia Civil'],
            'data' => [count($alunosComputação), count($alunosEletrica), count($alunosCivil)]
        ]);

        $dadosGraficoStack = json_encode([
            'labels' => ['Engenharia de Computação', 'Engenharia Elétrica', 'Engenharia Civil'],
            'data' => $contagemPorCursoPorAno,
        ]);

        // Converta os resultados em um formato que pode ser facilmente lido pelo JavaScript (JSON)
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

        return view(self::VIEW, $this->dadosPagina);
    }
}
