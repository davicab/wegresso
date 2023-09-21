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

    public function index(){

        if(!Auth::check()) return redirect('/login');

        $userType = Auth::user()->type;
        $userId = Auth::user()->id;
        $userCurso = Auth::user()->curso_id;

        $rightCursos = $this->curso->getCursosById($userCurso);

        if($userType != '2') return redirect('/painel-administracao');

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

        return view(self::VIEW, $this->dadosPagina);
    }

    public function salvarPerfil(Request $request)
    {
        $userId = Auth::user()->id;
        $userType = Auth::user()->type;

        $aluno = User::find($userId);

        if (!$aluno) {
            return redirect('/perfil')->with('responseError', 'Usuário não encontrado.');
        }

        if ($userType != 2 || $aluno->id !== $userId) {
            return redirect('/perfil')->with('responseError', 'Permissão negada.');
        }

        $aluno->is_employed = $request->input('empregado');
        $aluno->permite_dados = $request->input('permite_dados');
        $aluno->experiencias = $request->input('experiencias');
        $aluno->atual_emprego = $request->input('atual_emprego');

        try{
            $result = $aluno->save();
            return redirect('/perfil')->with('responseSuccess', 'Usuário salvos com sucesso.');
        } catch(\Exception $e) {
            return redirect('/perfil')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }

    }
}
