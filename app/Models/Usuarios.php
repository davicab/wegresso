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
        'email_verified_at'
    ];

    // Usuarios type = 0 -- Root
    // Usuarios type = 1 -- Administradores
    // Usuarios type = 2 -- Alunos

    // Curso = 0 -- Computação
    // Curso = 1 -- Eletrica
    // Curso = 2 -- Civil

    public function getAlunos(){
        $dados = DB::table($this->table)
            ->select('id', 'name', 'ano_egresso')
            ->where('type', '2')
            ->orderBy('name', 'asc')
            ->get();
        return $dados;
    }

    public function getAnosEgresso(){
        $dados = DB::table($this->table)
            ->where('type', '2')
            ->distinct()
            ->orderByRaw('CAST(ano_egresso AS UNSIGNED)')
            ->pluck('ano_egresso');

        return $dados;
    }

    public function getAlunosAgrupadosPorAnoEgresso(){
        $dados = DB::table($this->table)
            ->where('type', '2')
            ->selectRaw('ano_egresso, COUNT(*) as count')
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    public function getAlunosComputacao(){
        $dados = DB::table($this->table)
            ->where('curso', '0')
            ->select('id', 'name', 'ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getAlunosEletrica(){
        $dados = DB::table($this->table)
            ->where('curso', '1')
            ->select('id', 'name', 'ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getAlunosCivil(){
        $dados = DB::table($this->table)
            ->where('curso', '2')
            ->select('id', 'name', 'ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getUserByEmail($email){
        $dados = DB::table($this->table)
            ->select('*')
            ->where('email', $email)
            ->where('type', '2')
            ->first();
        return $dados;
    }

    public function getAlunosAgrupadosPorCursoPorAno(){
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
            ->groupBy('ano_egresso')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

}
