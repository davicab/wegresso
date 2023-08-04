<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Cursos;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

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

    // public function curso(): BelongsTo
    // {
    //     return $this->belongsTo(Cursos::class, 'curso_id');
    // }

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
            ->where('curso_id', '1')
            ->where('permite_dados', '1')
            ->select('ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getAlunosEletrica(){
        $dados = DB::table($this->table)
            ->where('curso_id', '2')
            ->where('permite_dados', '1')
            ->select('ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getAlunosCivil(){
        $dados = DB::table($this->table)
            ->where('curso_id', '3')
            ->where('permite_dados', '1')
            ->select('ano_egresso', 'ano_ingresso')
            ->get();
        return $dados;
    }

    public function getUserById($id){
        $dados = DB::table($this->table)
            ->select('id', 'name', 'curso_id', 'is_employed', 'ano_egresso', 'ano_ingresso', 'status', 'experiencias', 'atual_emprego')
            ->where('id', $id)
            ->where('type', '2')
            ->first();
        return $dados;
    }

    // public function getAlunosAgrupadosGeralPorAno(){
    //     $dados = DB::table($this->table)
    //         ->select('ano_egresso')
    //         ->selectRaw('
    //             SUM(CASE WHEN curso = 0 THEN 1 ELSE 0 END) as curso0,
    //             SUM(CASE WHEN curso = 1 THEN 1 ELSE 0 END) as curso1,
    //             SUM(CASE WHEN curso = 2 THEN 1 ELSE 0 END) as curso2
    //         ')
    //         ->groupBy('ano_egresso')
    //         ->orderBy('ano_egresso', 'asc')
    //         ->get();
    
    //     $dados = [];
    
    //     foreach ($anos as $ano) {
    //         $cursoCounts = DB::table($this->table)
    //             ->select('curso_id', DB::raw('COUNT(*) as count'))
    //             ->where('ano_egresso', $ano->ano_egresso)
    //             ->groupBy('curso_id')
    //             ->get();
    
    //         $dadosAno = [
    //             'ano_egresso' => $ano->ano_egresso,
    //         ];
    
    //         foreach ($cursoCounts as $cursoCount) {
    //             $curso = "curso{$cursoCount->curso_id}";
    //             $dadosAno[$curso] = (string) $cursoCount->count;
    //         }
    
    //         $dados[] = $dadosAno;
    //     }
    
    //     return $dados;
    // }
    
    

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
            ->where('curso_id', $curso)
            ->where('type', '2')
            ->where('permite_dados', '1')
            ->orderBy('ano_egresso', 'asc')
            ->get();
        return $dados;
    }

    public function getCountAlunosByCurso($curso){
        $dados = DB::table($this->table)
            ->selectRaw('ano_egresso, COUNT(*) as count')
            ->where('curso_id', $curso)
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
        ->where('status', '0')
        ->whereNotNull('experiencias')
        ->orderBy('ano_egresso', 'asc')
        ->get();
    return $dados;
    }
    public function getUserByEmail($email){
        $dados = DB::table($this->table)
            ->select('id')
            ->where('email', $email)
            ->get();
        return $dados;
    }


}
