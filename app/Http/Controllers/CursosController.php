<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class CursosController extends Controller
{
    private $usuarios;
    private $dadosPagina;
    private $cursos;

    const VIEW = 'curso';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->cursos = new Cursos();
        $this->dadosPagina = array();
    }

    public function index(){

        $cursos = $this->cursos->getCursos();
        $auth = Auth::check();
        $authUser = Auth::user();
        $canSee = false;

        if($auth && $authUser->type != 2){
            $canSee = true;
        }
        // dd($this->cursos->getCursoByCodigo($curso));

        // if (array_key_exists($curso, $requestCursos)) {
        //     $egressosData = $this->usuarios->getAlunoByCurso($requestCursos[$curso]);
        //     // Proteger os nomes dos usuários e criar o array $egressosFormatados
        //     $egressosFormatados = [];
        //     foreach ($egressosData as $egressoData) {
        //         $egresso = new stdClass();
        //         if($canSee == true){
        //             $egresso->name = $egressoData->name;
        //         }else{
        //             $egresso->name = $this->protegerNome($egressoData->name);
        //         }
        //         $egresso->ano_egresso = $egressoData->ano_egresso;
        //         $egressosFormatados[] = $egresso;
        //     }

        //     $this->dadosPagina['curso'] = array_search($requestCursos[$curso], $rightCursos);
        //     $this->dadosPagina['cursoCode'] = $requestCursos[$curso];

        //     $this->dadosPagina['egressos'] = $egressosFormatados;
        // }

        $this->dadosPagina['highUser'] = false;

        $this->dadosPagina['cursos'] = $cursos;

        $this->dadosPagina['auth'] = Auth::check();

        if(Auth::check()){
            $userType = Auth::user()->type;
            if($userType == '0' || $userType = 1){
                $this->dadosPagina['highUser'] = true;
            }
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
