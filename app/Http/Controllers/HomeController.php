<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

class HomeController extends Controller
{
    private $usuarios;
    private $dadosPagina;

    const VIEW = 'index';

    public function __construct() {
        $this->usuarios = new Usuarios();
        $this->dadosPagina = array();
        // $this->cards = new Card();
    }

    public function index(){
        $this->dadosPagina['alunos'] = $this->usuarios->getAlunos();

        return view(self::VIEW, $this->dadosPagina);
    }
}
