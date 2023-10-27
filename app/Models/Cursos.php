<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cursos extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'id',
        'codigo',
        'descricao',
    ];

    /**
     * Obtém todos os cursos.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCursos(){
        $dados = DB::table($this->table)
            ->select('id', 'codigo', 'descricao')
            ->orderBy('id', 'asc')
            ->get();
        return $dados;
    }

    /**
     * Obtém um curso pelo ID.
     *
     * @param int $id
     * @return object|null
     */
    public function getCursosById($id){
        $dados = DB::table($this->table)
            ->select('id', 'codigo', 'descricao')
            ->where('id', $id)
            ->orderBy('descricao', 'asc')
            ->first();
        return $dados;
    }

    /**
     * Verifica se um curso existe pelo código e cria se não existir.
     *
     * @param string $codigoCurso
     * @param string $descricaoCurso
     * @return object
     */
    public function verificarOuCriarCurso($codigoCurso , $descricaoCurso){

        $curso = Cursos::where('codigo', $codigoCurso)->first();

        if (!$curso) {
            $curso = Cursos::create([
                'codigo' => strtolower($codigoCurso),
                'descricao' => $descricaoCurso,
            ]);
            return $curso;
        }

        return $curso;
    }

    /**
     * Obtém a quantidade de alunos por curso.
     *
     * @return \Illuminate\Support\Collection
     */
    public  static function getQuantidadeAlunoPorCurso(){
        $dados = DB::table('wegresso_table.cursos AS C')
            ->select('U.ano_egresso', 'C.descricao', 'C.id', DB::raw('COUNT(U.id) as count'), 'C.codigo')
            ->where('type', '2')
            ->join('wegresso_table.users AS U', 'C.id', '=', 'U.curso_id')
            ->groupBy('U.ano_egresso', 'C.descricao', 'C.id', 'C.codigo')
            ->get();
        return $dados;
    }

    /**
     * Obtém a quantidade de alunos empregados por curso.
     *
     * @return \Illuminate\Support\Collection
     */
    public  static function getQuantidadeEmpregadosPorCurso(){
        $dados = DB::table('wegresso_table.cursos AS C')
            ->select('U.ano_egresso', 'C.descricao', 'C.id', DB::raw('COUNT(U.id) as count'))
            ->where('U.type', '2')
            ->where('U.is_employed', '1')
            ->join('wegresso_table.users AS U', 'C.id', '=', 'U.curso_id')
            ->groupBy('U.ano_egresso', 'C.descricao', 'C.id')
            ->get();
        return $dados;
    }

    /**
     * Obtém um curso pelo código.
     *
     * @param string $codigo
     * @return object|null
     */
    public function getCursoByCodigo($codigo){
        $dados = DB::table($this->table)
            ->select('id', 'descricao', 'codigo')
            ->where('codigo', $codigo)
            ->first();
        return $dados;
    }
}
