<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'remember_token',
        'password',
        'email_verified_at',
        'status',
        'permite_dados',
        'type',
    ];

    /**
     * Obtém todos os alunos com dados permitidos.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAlunos(){
        $dados = DB::table($this->table)
            ->select('id', 'name', 'ano_egresso', 'curso_id')
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->orderBy('name', 'asc')
            ->get();
        return $dados;
    }

    /**
     * Obtém o número de alunos por curso.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAlunosPorCurso()
    {
        $alunosPorCurso = DB::table('users')
            ->select('curso_id', DB::raw('COUNT(*) as total_alunos'))
            ->where('type', '2')
            ->groupBy('curso_id')
            ->get();

        return $alunosPorCurso;
    }

    /**
     * Obtém a contagem de alunos agrupados por ano de egresso.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAlunosAgrupadosPorAnoEgresso(){
        $dados = DB::table($this->table)
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->selectRaw('ano_egresso, COUNT(*) as count')
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    /**
     * Obtém informações de um usuário pelo ID.
     *
     * @param int $id
     * @return object|null
     */
    public function getUserById($id){
        $dados = DB::table($this->table)
            ->select('id','email', 'name', 'curso_id', 'is_employed', 'ano_egresso', 'ano_ingresso', 'status', 'experiencias', 'atual_emprego')
            ->where('id', $id)
            ->where('type', '2')
            ->first();
        return $dados;
    }

    /**
     * Obtém a contagem de alunos empregados por ano de egresso.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAlunosEmpregados(){
        $dados = DB::table($this->table)
            ->select('ano_egresso')
            ->selectRaw('SUM(CASE WHEN is_employed = 1 THEN 1 ELSE 0 END) as empregados')
            ->where('is_employed', '1')
            ->where('permite_dados', '1')
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    /**
     * Obtém os alunos de um curso específico.
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function getAlunoByCurso($id){
        $dados = DB::table($this->table)
            ->select('name', 'id', 'ano_egresso', 'ano_ingresso')
            ->where('type', '2')
            ->where('curso_id', $id)
            ->where('permite_dados', '1')
            ->orderBy('name', 'asc')
            ->get();
        return $dados;
    }

    /**
     * Obtém a contagem de alunos empregados por ano de egresso para um curso específico.
     *
     * @param int $curso
     * @return \Illuminate\Support\Collection
     */
    public function getAlunosEmpregadosCurso($curso){
        $dados = DB::table($this->table)
            ->select('ano_egresso')
            ->selectRaw('SUM(CASE WHEN is_employed = 1 THEN 1 ELSE 0 END) as empregados')
            ->where('is_employed', '1')
            ->where('permite_dados', '1')
            ->where('curso_id', $curso)
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    /**
     * Obtém dados de alunos não verificados e empregados.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDadosAlunos(){
        $dados = DB::table($this->table)
            ->select('id','name')
            ->where('is_employed', '1')
            ->where('type', '2')
            ->where('status', '0')
            ->whereNotNull('experiencias')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    /**
     * Obtém todos os alunos.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllAlunos(){
        $dados = DB::table('users')
            ->select('curso_id', 'ano_ingresso', 'ano_egresso')
            ->where('type', '2')
            ->get();
        return $dados;
    }

    /**
     * Obtém um usuário pelo email.
     *
     * @param string $email
     * @return object|null
     */
    public function getAlunoByEmail($email){
        $dados = DB::table($this->table)
            ->select('id')
            ->where('email', $email)
            ->get();
        return $dados;
    }
}
