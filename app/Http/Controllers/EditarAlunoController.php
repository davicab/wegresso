<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\User;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Support\Str;

class EditarAlunoController extends Controller
{
    private $usuarios;
    private $dadosPagina;
    private $cursos;

    const VIEW = 'edita-aluno';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
        $this->cursos = new Cursos();
    }

    public function index(Request $request, $id){
        $aluno_info = $this->usuarios->getUserById($id);

        $curso = $this->cursos->getCursosById($aluno_info->curso_id);

        $this->dadosPagina['infoUser'] = $aluno_info;
        $this->dadosPagina['cursoUser'] = $curso;
        if(!Auth::check() || Auth::user()->type == 2){
            return redirect('/')->with('responseError', 'Permissao negada!');
        }

        return view(self::VIEW, $this->dadosPagina);

    }

    public function editaDados(Request $request, $id)
    {
        $userType = Auth::user()->type;

        if($userType == '2') return redirect('/')->with('responseError', 'Permissão negada.');

        $aluno = User::find($id);

        $aluno->name = $request->input('name');
        $aluno->email = $request->input('email');
        $aluno->ano_egresso = $request->input('ano_egresso');
        $aluno->ano_ingresso = $request->input('ano_ingresso');
        $aluno->experiencias = $request->input('experiencias');
        $aluno->atual_emprego = $request->input('atual_emprego');

        if (!$aluno) {
            return redirect('/perfil')->with('responseError', 'Usuário não encontrado.');
        }

        try{
            $result = $aluno->save();
            return redirect('/editar-aluno/' . $id)->with('responseSuccess', 'Usuário salvo com sucesso.');
        } catch(\Exception $e) {
            return redirect('/painel-administracao')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }
    }
}
