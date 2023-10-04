<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\User;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Exibe a página de edição de aluno.
     *
     * @param Request $request
     * @param int $id - ID do aluno a ser editado
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id){
        // Obtém informações do aluno pelo ID
        $aluno_info = $this->usuarios->getUserById($id);

        // Obtém informações do curso do aluno
        $curso = $this->cursos->getCursosById($aluno_info->curso_id);

        // Define informações do usuário e curso para serem passadas para a visão
        $this->dadosPagina['infoUser'] = $aluno_info;
        $this->dadosPagina['cursoUser'] = $curso;

        // Verifica a autenticação e o tipo de usuário antes de exibir a página
        if(!Auth::check() || Auth::user()->type == 2){
            return redirect('/')->with('responseError', 'Permissao negada!');
        }

        // Exibe a visão com os dados do aluno
        return view(self::VIEW, $this->dadosPagina);
    }

    /**
     * Atualiza os dados do aluno.
     *
     * @param Request $request
     * @param int $id - ID do aluno a ser editado
     * @return \Illuminate\Http\Response
     */
    public function editaDados(Request $request, $id)
    {
        // Obtém o tipo de usuário autenticado
        $userType = Auth::user()->type;

        // Verifica se o usuário tem permissão para editar
        if($userType == '2') return redirect('/')->with('responseError', 'Permissão negada.');

        // Encontra o aluno pelo ID
        $aluno = User::find($id);

        // Atualiza os dados do aluno com base nos dados do formulário
        $aluno->name = $request->input('name');
        $aluno->email = $request->input('email');
        $aluno->ano_egresso = $request->input('ano_egresso');
        $aluno->ano_ingresso = $request->input('ano_ingresso');
        $aluno->experiencias = $request->input('experiencias');
        $aluno->atual_emprego = $request->input('atual_emprego');

        // Verifica se o aluno foi encontrado
        if (!$aluno) {
            return redirect('/perfil')->with('responseError', 'Usuário não encontrado.');
        }

        try{
            // Salva as alterações nos dados do aluno
            $result = $aluno->save();
            return redirect('/editar-aluno/' . $id)->with('responseSuccess', 'Usuário salvo com sucesso.');
        } catch(\Exception $e) {
            return redirect('/painel-administracao')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }
    }
}
