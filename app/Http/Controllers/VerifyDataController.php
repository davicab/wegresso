<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuarios;
use App\Models\Cursos;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyDataController extends Controller
{
    private $dadosPagina;
    private $usuarios;
    private $cursos;

    const VIEW = 'verificar-dados';
    const VIEW_USER = 'verificar-user';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->cursos = new Cursos();
        $this->dadosPagina = array();
    }

    public function index(){

        // if(!Auth::check()) return redirect('/login');

        // $userType = Auth::user()->type;

        // if($userType != '1' && $userType != '0') {
        //     return redirect('/perfil');
        // }

        $this->dadosPagina['alunos'] = $this->usuarios->getAlunos();

        $this->dadosPagina['nao_verificados'] = $this->usuarios->getDadosAlunos();

        $this->dadosPagina['cursos'] = $this->cursos->getCursos();

        $this->dadosPagina['auth'] = Auth::check();

        return view(self::VIEW, $this->dadosPagina);
    }

    public function userVerfiyView(Request $request, $id){
        $rightCursos = [
            1 => 'Engenharia de Computação',
            2 => 'Engenharia Elétrica',
            3 => 'Engenharia Civil' ,
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

    public function createCurso(Request $request){

        $curso = $this->cursos;

        $curso->nome = $request->input('nome');

        $curso->descricao = $request->input('descricao');

        try{
            $result = $curso->save();
            return redirect('/painel-administracao')->with('responseSuccess', 'Curso criado com sucesso.');
        } catch(\Exception $e) {
            return redirect('/painel-administracao')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }
    }

    public function importData(Request $request){

        $resp = $request->question;

        if(!$resp = "1") return redirect('/painel-administracao')->with('responseError', 'Importação não permitida.');

        $jsonData = file_get_contents('../public/files/alunos.json');

        $cleanData = json_decode($jsonData, true);

        $usuariosConcluidos = array_filter($cleanData, function ($usuario) {
            return $usuario['Situação no Curso'] === 'Concluído' || $usuario['Situação no Curso'] === 'Formado';
        });

        // dd($usuariosConcluidos);

        foreach($usuariosConcluidos as $usuario){

            if($usuario['Situação no Curso'] == 'Concluído'){
                $dataEgresso = $usuario['Data de Conclusão de Curso'];
                $datetime = DateTime::createFromFormat('d/m/Y', $dataEgresso);

                if ($datetime !== false) {
                    $dataFinal = $datetime->format('Y');
                } else {
                    $dataFinal = 0;
                }
            }else{
                $dataFinal = $usuario['Ano de Conclusão'];
            }



            $curso = $this->cursos->verificarOuCriarCurso($usuario['Código Curso'], $usuario['Descrição do Curso']);

            try{

                User::create([
                    'name' => $usuario['Nome'],
                    'email' => $usuario['Email Pessoal'],
                    'type' => 2,
                    'ano_ingresso' => $usuario['Ano de Ingresso'],
                    'ano_egresso' => $dataFinal,
                    'permite_dados' => 1,
                    'status' => 0,
                    'curso_id' => $curso->id,
                    'is_employed' => random_int(0, 1),
                ]);
            } catch(\Exception $e) {
                var_dump($e);
                return redirect('/perfil')->with('responseError', 'Ocorreu um erro, tente novamente.');
            }

        }

        return redirect('/painel-administracao')->with('responseSuccess', 'Usuário salvos com sucesso.');


        // Agora $usuariosConcluidos conterá apenas os usuários com a situação do curso "Concluído" ou "Formado"
        // dd($usuariosConcluidos);
    }
}
