<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent;
use App\Models\User;
use App\Models\Usuarios;
use App\Http\Middleware\Authenticate;

class PerfilController extends Controller
{
    private $dadosPagina;
    private $usuarios;

    const VIEW = 'perfil';

    public function __construct() {
        $this->dadosPagina = array();
    }

    public function index(){

        if(!Auth::check()) return redirect('/login');

        $userType = Auth::user()->type;
        $userId = Auth::user()->id;
        $userCurso = Auth::user()->curso;

        $rightCursos = [
            0 => 'Engenharia de Computação',
            1 => 'Engenharia Elétrica',
            2 =>'Engenharia Civil' ,
        ];

        if($userType != '2'){
            return redirect('/painel-administracao');
        }else{
            $this->dadosPagina['user'] = 'aluno';
            $this->dadosPagina['id'] = $userId;
            $this->dadosPagina['name'] = Auth::user()->name;
            $this->dadosPagina['curso'] = $rightCursos[$userCurso];
            $this->dadosPagina['empregado'] = Auth::user()->is_employed;
            $this->dadosPagina['ano_egresso'] = Auth::user()->ano_egresso;
            $this->dadosPagina['ano_ingresso'] = Auth::user()->ano_ingresso;
            $this->dadosPagina['atual_emprego'] = Auth::user()->atual_emprego;
            $this->dadosPagina['experiencias'] = Auth::user()->experiencias;
            $this->dadosPagina['permite_dados'] = Auth::user()->permite_dados;
        }


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


        $this->validate($request, [
            'curso' => 'required|max:200',
            'ano_ingresso' => 'required|date_format:Y',      
            'ano_egresso' => 'required|date_format:Y',
            'is_employed' => 'nullable|max:1',
            'permite_dados' => 'nullable|max:1',
            'atual_emprego' => 'nullable|max:200',
            'experiencias' => 'nullable|max:1000',  
        ]);


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
