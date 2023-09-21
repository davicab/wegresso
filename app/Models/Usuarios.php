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

    // Usuarios type = 0 -- Root
    // Usuarios type = 1 -- Administradores
    // Usuarios type = 2 -- Alunos

    // status = 0 -- dados não verificados
    // status = 1 -- dados verificados

    public function getAlunos(){
        $dados = DB::table($this->table)
            ->select('id', 'name', 'ano_egresso', 'curso_id')
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->orderBy('name', 'asc')
            ->get();
        return $dados;
    }

    public function getAlunosPorCurso()
    {
        $alunosPorCurso = DB::table('users')
            ->select('curso_id', DB::raw('COUNT(*) as total_alunos'))
            ->where('type', '2')
            ->groupBy('curso_id')
            ->get();

        return $alunosPorCurso;
    }

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

    public function getUserById($id){
        $dados = DB::table($this->table)
            ->select('id','email', 'name', 'curso_id', 'is_employed', 'ano_egresso', 'ano_ingresso', 'status', 'experiencias', 'atual_emprego')
            ->where('id', $id)
            ->where('type', '2')
            ->first();
        return $dados;
    }


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
    public function getAllAlunos(){
        $dados = DB::table('users')
            ->select('curso_id', 'ano_ingresso', 'ano_egresso')
            ->get();
        return $dados;
    }

    public function getAlunoByEmail($email){
        $dados = DB::table($this->table)
            ->select('id')
            ->where('email', $email)
            ->get();
        return $dados;
    }
}
