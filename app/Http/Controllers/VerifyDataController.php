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

    public function validarDados(Request $request)
    {
        dd($request);
        $userType = Auth::user()->type;
        if($userType == '2') return redirect('/')->with('responseError', 'Permissão negada.');


    }
}
