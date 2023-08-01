<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyDataController extends Controller
{
    private $dadosPagina;
    private $usuarios;

    const VIEW = 'verificar-dados';
    const VIEW_USER = 'verificar-user';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
    }

    public function index(){

        if(!Auth::check()) return redirect('/login');

        $userType = Auth::user()->type;

        if($userType != '1' && $userType != '0') {
            return redirect('/perfil');
        }

        $this->dadosPagina['nao_verificados'] = $this->usuarios->getDadosAlunos();

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }

    public function userVerfiyView(Request $request, $id){
        $rightCursos = [
            0 => 'Engenharia de Computação',
            1 => 'Engenharia Elétrica',
            2 => 'Engenharia Civil' ,
        ];

        if(!Auth::check()) return redirect('/login');

        $userType = Auth::user()->type;

        if($userType != '1' && $userType != '0') {
            return redirect('/perfil')->with('responseError', 'Permissão negada.');
        }
        
        $this->dadosPagina['infoUser'] = $this->usuarios->getUserById($id);

        return view(self::VIEW_USER, $this->dadosPagina);

    }

    public function validarDados(Request $request, $id)
    {
        $userType = Auth::user()->type;

        if($userType == '2') return redirect('/')->with('responseError', 'Permissão negada.');

        $aluno = User::find($id);

        if (!$aluno) {
            return redirect('/perfil')->with('responseError', 'Usuário não encontrado.');
        }
        
        $aluno->status = $request->input('status');

        try{
            $result = $aluno->save();
            return redirect('/painel-administracao')->with('responseSuccess', 'Usuário salvos com sucesso.');
        } catch(\Exception $e) {
            return redirect('/painel-administracao')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }
    }
}
