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
        'status'
    ];

    // Usuarios type = 0 -- Root
    // Usuarios type = 1 -- Administradores
    // Usuarios type = 2 -- Alunos

    // Curso = 0 -- Computação
    // Curso = 1 -- Eletrica
    // Curso = 2 -- Civil

    // status = 0 -- dados não verificados
    // status = 1 -- dados verificados

    public function getAlunos(){
        $dados = DB::table($this->table)
            ->select('id', 'name', 'ano_egresso')
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->orderBy('name', 'asc')
            ->get();
        return $dados;
    }

    public function getAnosEgresso(){
        $dados = DB::table($this->table)
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->distinct()
            ->orderByRaw('CAST(ano_egresso AS UNSIGNED)')
            ->pluck('ano_egresso');

        return $dados;
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

    public function getAlunosComputacao(){
        $dados = DB::table($this->table)
            ->where('curso', '0')
            ->where('permite_dados', '1')
            ->select('ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getAlunosEletrica(){
        $dados = DB::table($this->table)
            ->where('curso', '1')
            ->where('permite_dados', '1')
            ->select('ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getAlunosCivil(){
        $dados = DB::table($this->table)
            ->where('curso', '2')
            ->where('permite_dados', '1')
            ->select('ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getUserById($id){
        $dados = DB::table($this->table)
            ->select('id', 'name', 'email', 'curso', 'is_employed', 'ano_egresso', 'ano_ingresso')
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->where('id', $id)
            ->first();
        return $dados;
    }

    public function getAlunosAgrupadosGeralPorAno(){
        $dados = DB::table($this->table)
            ->select('ano_egresso')
            ->selectRaw('
                SUM(CASE WHEN curso = 0 THEN 1 ELSE 0 END) as curso0,
                SUM(CASE WHEN curso = 1 THEN 1 ELSE 0 END) as curso1,
                SUM(CASE WHEN curso = 2 THEN 1 ELSE 0 END) as curso2
            ')
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();

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

    public function getAlunoByCurso($curso){
        $dados = DB::table($this->table)
            ->select('name', 'ano_egresso')
            ->where('curso', $curso)
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    public function getCountAlunosByCurso($curso){
        $dados = DB::table($this->table)
            ->selectRaw('ano_egresso, COUNT(*) as count')
            ->where('curso', $curso)
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    public function getAlunosEmpregadosCurso($curso){
        $dados = DB::table($this->table)
            ->select('ano_egresso')
            ->selectRaw('SUM(CASE WHEN is_employed = 1 THEN 1 ELSE 0 END) as empregados')
            ->where('is_employed', '1')
            ->where('permite_dados', '1')
            ->where('curso', $curso)
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    public function getDadosAlunos(){
        $dados = DB::table($this->table)
        ->select('id','name','atual_emprego', 'experiencias')
        ->where('is_employed', '1')
        ->where('status', '0')
        ->orderBy('ano_egresso', 'asc')
        ->get();
    return $dados;
    }

}
