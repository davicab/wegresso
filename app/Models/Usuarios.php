<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Usuarios extends Model
{
    use HasFactory;


    protected $table = 'users';

    public function getAlunos(){
        $dados = DB::table($this->table)
            ->select('id', 'name')
            ->where('type', '1')
            ->orderBy('name', 'asc')
            ->get();
        return $dados;
    }

}
