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

    // public function users() : HasMany
    // {
    //     return $this->hasMany(Usuarios::class , 'curso_id' , 'id');
    // }

    public function getCursos(){
        $dados = DB::table($this->table)
            ->select('id', 'codigo', 'descricao')
            ->orderBy('id', 'asc')
            ->get();
        return $dados;
    }


    public function verificarOuCriarCurso($codigoCurso , $descricaoCurso){

        $curso = Cursos::where('codigo', $codigoCurso)->first();

        if (!$curso) {
            $curso = Cursos::create([
                'codigo' => $codigoCurso,
                'descricao' => $descricaoCurso,
            ]);
            return $curso;
        }
    
        return $curso;


    }

    public  static function getQuantidadeAlunoPorCurso(){
        $dados = DB::table('cursos as C')
            ->select('U.ano_egresso', 'U.ano_ingresso', 'C.id', 'C.descricao', DB::raw('count(U.id) as count'))
            ->join('users as U', 'C.id', '=', 'U.curso_id')
            ->groupBy('U.ano_egresso', 'U.ano_ingresso', 'C.descricao', 'C.id',)
            ->get();
        return $dados;
    }

}
