<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent;
use App\Models\User;
use App\Http\Middleware\Authenticate;
use App\Models\Cursos;

class PerfilController extends Controller
{
    private $dadosPagina;
    private $curso;

    const VIEW = 'perfil';

    public function __construct() {
        $this->dadosPagina = array();
        $this->curso = new Cursos();
    }

    /**
     * Exibe a página de perfil do usuário.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        // Verifica se o usuário está autenticado
        if(!Auth::check()) return redirect('/login');

        // Obtém informações do usuário autenticado
        $userType = Auth::user()->type;
        $userId = Auth::user()->id;
        $userCurso = Auth::user()->curso_id;

        // Obtém informações do curso do usuário
        $rightCursos = $this->curso->getCursosById($userCurso);

        // Verifica o tipo de usuário e redireciona se necessário
        if($userType != '2') return redirect('/painel-administracao');

        // Define informações do usuário para a visão
        $this->dadosPagina['user'] = 'aluno';
        $this->dadosPagina['id'] = $userId;
        $this->dadosPagina['name'] = Auth::user()->name;
        $this->dadosPagina['curso'] = $rightCursos->descricao;
        $this->dadosPagina['empregado'] = Auth::user()->is_employed;
        $this->dadosPagina['ano_egresso'] = Auth::user()->ano_egresso;
        $this->dadosPagina['ano_ingresso'] = Auth::user()->ano_ingresso;
        $this->dadosPagina['atual_emprego'] = Auth::user()->atual_emprego;
        $this->dadosPagina['experiencias'] = Auth::user()->experiencias;
        $this->dadosPagina['permite_dados'] = Auth::user()->permite_dados;

        $this->dadosPagina['auth'] = Auth::check();

        // Exibe a visão do perfil do usuário
        return view(self::VIEW, $this->dadosPagina);
    }

    /**
     * Salva as informações do perfil do usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function salvarPerfil(Request $request)
    {
        // Obtém o ID e o tipo de usuário autenticado
        $userId = Auth::user()->id;
        $userType = Auth::user()->type;

        // Encontra o usuário pelo ID
        $aluno = User::find($userId);

        // Verifica se o usuário foi encontrado
        if (!$aluno) {
            return redirect('/perfil')->with('responseError', 'Usuário não encontrado.');
        }

        // Verifica se o usuário tem permissão para editar seu perfil
        if ($userType != 2 || $aluno->id !== $userId) {
            return redirect('/perfil')->with('responseError', 'Permissão negada.');
        }

        // Atualiza as informações do perfil com base nos dados do formulário
        $aluno->is_employed = $request->input('empregado');
        $aluno->permite_dados = $request->input('permite_dados');
        $aluno->experiencias = $request->input('experiencias');
        $aluno->atual_emprego = $request->input('atual_emprego');

        try{
            // Salva as alterações no perfil do usuário
            $result = $aluno->save();
            return redirect('/perfil')->with('responseSuccess', 'Usuário salvo com sucesso.');
        } catch(\Exception $e) {
            return redirect('/perfil')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }
    }
}
