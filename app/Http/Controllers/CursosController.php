<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use stdClass;

class CursosController extends Controller
{
    private $usuarios;
    private $dadosPagina;

    const VIEW = 'egresso-curso';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
    }

    public function index(Request $request, $curso){
        $requestCursos = [
            'computacao' => 0,
            'eletrica' => 1,
            'civil' => 2,
        ];
    
        $rightCursos = [
            'Engenharia de Computação' => 0,
            'Engenharia Elétrica' => 1,
            'Engenharia Civil' => 2,
        ];
    
        if (array_key_exists($curso, $requestCursos)) {
            $egressosData = $this->usuarios->getAlunoByCurso($requestCursos[$curso]);
            // Proteger os nomes dos usuários e criar o array $egressosFormatados
            $egressosFormatados = [];
            foreach ($egressosData as $egressoData) {
                $egresso = new stdClass();
                $egresso->name = $this->protegerNome($egressoData->name);
                $egresso->ano_egresso = $egressoData->ano_egresso;
                $egressosFormatados[] = $egresso;
            }

            $this->dadosPagina['curso'] = array_search($requestCursos[$curso], $rightCursos);
            $this->dadosPagina['egressos'] = $egressosFormatados;
        }
    
        return view(self::VIEW, $this->dadosPagina);
    }
    
    // Função para proteger o nome dos usuários
    private function protegerNome($nome){
        $primeiraLetra = substr($nome, 0, 1);
        $tamanhoNome = strlen($nome);
        $restoNome = str_repeat('*', $tamanhoNome - 1);
    
        return $primeiraLetra . $restoNome;
    }
    
}
