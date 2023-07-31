<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

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

        $contagemGeralPorAno = $this->usuarios->getAlunosAgrupadosGeralPorAno();

        $alunosEmpregados = $this->usuarios->getAlunosEmpregados();

        $alunosComputação = $this->usuarios->getAlunosComputacao();
        $alunosEletrica = $this->usuarios->getAlunosEletrica();
        $alunosCivil = $this->usuarios->getAlunosCivil();

        $dadosGraficoPie = json_encode([
            'labels' => ['Engenharia de Computação', 'Engenharia Elétrica', 'Engenharia Civil'],
            'data' => [count($alunosComputação), count($alunosEletrica), count($alunosCivil)]
        ]);

        $dadosGraficoStack = json_encode([
            'labels' => ['Engenharia de Computação', 'Engenharia Elétrica', 'Engenharia Civil'],
            'data' => $contagemGeralPorAno,
        ]);

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

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }
}
