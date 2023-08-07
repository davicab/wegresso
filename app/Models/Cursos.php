<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Expr\FuncCall;

class Cursos extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'id',
        'codigo',
        'descricao',
    ];

    public function getCursos(){
        $dados = DB::table($this->table)
            ->select('id', 'codigo', 'descricao')
            ->orderBy('descricao', 'asc')
            ->get();
        return $dados;
    }


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

    public  static function getQuantidadeAlunoPorCurso(){
        $dados = DB::table('laravel_web.cursos AS C')
            ->select('U.ano_egresso', 'C.descricao', 'C.id', DB::raw('COUNT(U.id) as count'))
            ->where('type', '2')
            ->join('laravel_web.users AS U', 'C.id', '=', 'U.curso_id')
            ->groupBy('U.ano_egresso', 'C.descricao', 'C.id')
            ->get();
        return $dados;
    }

    public  static function getQuantidadeEmpregadosPorCurso(){
        $dados = DB::table('laravel_web.cursos AS C')
            ->select('U.ano_egresso', 'C.descricao', 'C.id', DB::raw('COUNT(U.id) as count'))
            ->where('U.type', '2')
            ->where('U.is_employed', '1')
            ->join('laravel_web.users AS U', 'C.id', '=', 'U.curso_id')
            ->groupBy('U.ano_egresso', 'C.descricao', 'C.id')
            ->get();
        return $dados;
    }

    public function getCursoByCodigo($codigo){
        $dados = DB::table($this->table)
            ->select('id', 'descricao')
            ->where('codigo', $codigo)
            ->first();
        return $dados;
    }

}
