<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Support\Str;

class CursosController extends Controller
{
    private $usuarios;
    private $dadosPagina;
    private $cursos;

    const VIEW = 'curso';
    const VIEW_FILTER = 'alunos-curso';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->cursos = new Cursos();
        $this->dadosPagina = array();
    }

    public function index(){

        $cursos = $this->cursos->getCursos(); // consulta todos os cursos cadastrados no BD


        $arrSlug = []; // declara o array que armazena o slug (nome do curso encurtado e tratado)

        foreach ($cursos as $curso){
            $rmSufixo = preg_replace('/\s*-\s*(?:Integrado|Trindade)\s*/i', '', $curso->descricao); //remove o texto - Integrado - Trindade da descricao do curso
            $arrSlug[$curso->id] = Str::slug($rmSufixo, '-'); //seta a posicao da array de acordo com o id do curso e insere o slug desse curso
        }

        // Prepara os dados para a página de visualização e carrega a view correspondente 
        $this->dadosPagina['slug'] = $arrSlug; 

        $this->dadosPagina['highUser'] = false;

        $this->dadosPagina['cursos'] = $cursos;

        $this->dadosPagina['auth'] = Auth::check();

        // verifica o tipo de usuario para liberar funções, ou não, na view
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
        $primeiraLetra = substr($nome, 0, 1); // seleciona a primeira letra
        $tamanhoNome = strlen($nome); // comprimento do nome
        $restoNome = str_repeat('*', $tamanhoNome - 1); // restante do nome sem a primeira letra é substituido por *

        return $primeiraLetra . $restoNome; //retorna o nome protegido
    }

    //função de renderização da view individual de cada curso
    public function singleCurso(Request $request, $slug, $codigo){// recebe na request algumas variaves
        $infoCurso = $this->cursos->getCursoByCodigo($codigo); // busca as informações do curso de acordo com o codigo presente na request

        $alunos = $this->usuarios->getAlunoByCurso($infoCurso->id); // busca todos os alunos do curso buscado acima

        $auth = Auth::check(); //verifica se ha usuario autenticado (boolean)
        $authUser = Auth::user(); // captura informações do usuario autenticado
        $canSee = false; // variavel sera usada para liberar ou não a visualizacao do nome dos usuarios

        if($auth && $authUser->type != 2){ // verifica se tem usuario autenticado e se o tipo dele é diferente de 2, caso seja diferente, mantem bloqueada a visualizacao 
            $canSee = true;
        }

        $this->dadosPagina['curso'] = $infoCurso;

        // Proteger os nomes dos usuários e criar o array $egressosFormatados
        $egressosFormatados = [];
        foreach ($alunos as $egressoData) {
            $egresso = new stdClass();
            if($canSee == true){
                $egresso->name = $egressoData->name;
            }else{
                $egresso->name = $this->protegerNome($egressoData->name);
            }
            $egresso->ano_egresso = $egressoData->ano_egresso;
            $egressosFormatados[] = $egresso;
        }

        $this->dadosPagina['egressos'] = $egressosFormatados;

        // $this->dadosPagina['alunosCurso'] = alunos;
        return view(self::VIEW_FILTER, $this->dadosPagina);
    }

}
