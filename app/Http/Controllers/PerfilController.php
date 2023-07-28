<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent;

class PerfilController extends Controller
{
    private $dadosPagina;

    const VIEW = 'perfil';

    public function __construct() {
        $this->dadosPagina = array();
    }

    public function index(){

        $userType = Auth::user()->type;
        $userEmail = Auth::user()->email;

        if($userType != '2'){
            $this->dadosPagina['user'] = 'adm';
        }else{
            $this->dadosPagina['user'] = 'aluno';
            $this->dadosPagina['curso'] = Auth::user()->curso;
            $this->dadosPagina['empregado'] = Auth::user()->is_employed;
            $this->dadosPagina['ano_egresso'] = Auth::user()->ano_egresso;
            $this->dadosPagina['ano_ingresso'] = Auth::user()->ano_ingresso;
        }

        $this->dadosPagina['info'] = Auth::user();
        // dd(Auth::user());


        return view(self::VIEW, $this->dadosPagina);
    }

    public function salvarPerfil(Request $request)
    {
        $user = Auth::user();

        if ($user->type == 2) {
            $user->curso = $request->input('curso');
            $user->is_employed = $request->input('empregado') ? true : false;
            $user->ano_egresso = $request->input('ano_egresso');
            $user->ano_ingresso = $request->input('ano_ingresso');
        }

        // Salva as alterações no banco de dados
        // $user->save();

        // Redireciona o usuário para a página de perfil novamente
        return redirect()->route('perfil');
    }
}
