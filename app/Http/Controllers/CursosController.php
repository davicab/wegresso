<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    private $usuarios;
    private $dadosPagina;

    const VIEW = 'egresso-curso';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
    }

    public function index(Request $request , $curso){

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
            $this->dadosPagina['egressos'] = $this->usuarios->getAlunoByCurso($requestCursos[$curso]);
            $this->dadosPagina['curso'] = array_search($requestCursos[$curso], $rightCursos);
        }

        return view(self::VIEW, $this->dadosPagina);
    }


    private function protegerNome($nome){
        $primeiraLetra = substr($nome, 0, 1);
        $tamanhoNome = strlen($nome);
        $restoNome = str_repeat('*', $tamanhoNome - 1);

        return $primeiraLetra . $restoNome;
    }
}
