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

    /**
     * Exibe a página de verificação de dados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        // Verifica se o usuário está autenticado
        if(!Auth::check()) return redirect('/login');

        // Obtém o tipo de usuário autenticado
        $userType = Auth::user()->type;

        // Redireciona com base no tipo de usuário
        if($userType != '1' && $userType != '0') {
            return redirect('/perfil');
        }

        // Obtém informações dos alunos e cursos
        $this->dadosPagina['alunos'] = $this->usuarios->getAlunos();
        $this->dadosPagina['nao_verificados'] = $this->usuarios->getDadosAlunos();
        $this->dadosPagina['cursos'] = $this->cursos->getCursos();
        $this->dadosPagina['auth'] = Auth::check();

        // Exibe a visão de verificação de dados
        return view(self::VIEW, $this->dadosPagina);
    }

    /**
     * Exibe a página de verificação de dados de usuário.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function userVerfiyView(Request $request, $id){
        // Verifica se o usuário está autenticado
        if(!Auth::check()) return redirect('/login');

        // Obtém o tipo de usuário autenticado
        $userType = Auth::user()->type;

        // Redireciona com base no tipo de usuário
        if($userType != '1' && $userType != '0') {
            return redirect('/perfil')->with('responseError', 'Permissão negada.');
        }

        // Obtém informações do usuário a ser verificado
        $this->dadosPagina['infoUser'] = $this->usuarios->getUserById($id);

        // Exibe a visão de verificação de dados do usuário
        return view(self::VIEW_USER, $this->dadosPagina);
    }

    /**
     * Valida os dados de um usuário.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function validarDados(Request $request, $id)
    {
        // Obtém o tipo de usuário autenticado
        $userType = Auth::user()->type;

        // Redireciona se o usuário não tiver permissão
        if($userType == '2') return redirect('/')->with('responseError', 'Permissão negada.');

        // Encontra o usuário pelo ID
        $aluno = User::find($id);

        // Verifica se o usuário foi encontrado
        if (!$aluno) {
            return redirect('/perfil')->with('responseError', 'Usuário não encontrado.');
        }

        // Atualiza o status do usuário com base nos dados do formulário
        $aluno->status = $request->input('status');

        try{
            // Salva as alterações no status do usuário
            $result = $aluno->save();
            return redirect('/painel-administracao')->with('responseSuccess', 'Usuário salvo com sucesso.');
        } catch(\Exception $e) {
            return redirect('/painel-administracao')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }
    }

    /**
     * Cria um novo curso.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createCurso(Request $request){        
        // Verifica se o usuário está autenticado
        if(!Auth::check()) return redirect('/login');

        // Verifica se o usuário tem permissão para criar cursos
        if(Auth::user()->type == '2') return redirect('/')->with('responseError', 'Permissão negada.');

        $curso = $this->cursos;

        $curso->nome = $request->input('nome');

        $curso->descricao = $request->input('descricao');

        try{
            // Salva o novo curso
            $result = $curso->save();
            return redirect('/painel-administracao')->with('responseSuccess', 'Curso criado com sucesso.');
        } catch(\Exception $e) {
            return redirect('/painel-administracao')->with('responseError', 'Ocorreu um erro, tente novamente.');
        }
    }
    
    /**
     * Converte dados de um arquivo CSV em registros de usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function convertData(Request $request){
        // Verifica se o usuário está autenticado
        if(!Auth::check()) return redirect('/login');

        // Verifica se o usuário tem permissão para converter dados
        if(Auth::user()->type == '2') return redirect('/')->with('responseError', 'Permissão negada.');

        $arquivoCSV = $request->arquivo;
        $csvData = file_get_contents($arquivoCSV);
        $lines = explode(PHP_EOL, $csvData);
        $header = str_getcsv(array_shift($lines), ";");
        $result = [];

        foreach ($lines as $line) {
            $row = str_getcsv($line, ";");
            $rowData = [];
            foreach ($header as $index => $columnName) {
                $rowData[$columnName] = $row[$index];
            }
            $result[] = $rowData;
        }

        return $this->importData(json_encode($result));
    }

    /**
     * Importa dados de usuários a partir de um arquivo CSV.
     *
     * @param string $json_alunos
     * @return \Illuminate\Http\Response
     */
    public function importData($json_alunos){

        // Verifica se o usuário está autenticado
        if(!Auth::check()) return redirect('/login');

        // Verifica se o usuário tem permissão para importar dados
        if(Auth::user()->type == '2') return redirect('/')->with('responseError', 'Permissão negada.');

        // Converte os dados em formato JSON em um array
        $cleanData = json_decode($json_alunos, true);

        // Filtra os usuários concluídos do CSV
        $usuariosConcluidos = array_filter($cleanData, function ($usuario) {
            return $usuario['Situação no Curso'] === 'Concluído' || $usuario['Situação no Curso'] === 'Formado';
        });

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
                // Cria um novo registro de usuário com base nos dados do CSV
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
                continue;
            }

        }
        return redirect('/painel-administracao')->with('responseSuccess', 'Usuários salvos com sucesso.');
    }
}
