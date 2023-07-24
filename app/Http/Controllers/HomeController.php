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
        $this->dadosPagina['alunos'] = $this->usuarios->getAlunos();
        $this->dadosPagina['years'] = $this->usuarios->getAnosEgresso();

        // Converta os resultados em um formato que pode ser facilmente lido pelo JavaScript (JSON)
        $dadosGrafico = json_encode([
            'labels' => $contagemPorAno->pluck('ano_egresso')->toArray(),
            'data' => $contagemPorAno->pluck('count')->toArray(),
        ]);

        $this->dadosPagina['dadosGrafico'] = $this->usuarios->getAlunosAgrupadosPorAnoEgresso();

        return view(self::VIEW, $this->dadosPagina);
    }
}
