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

}
