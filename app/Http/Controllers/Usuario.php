<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Usuario extends Controller
{
    function conectar(){
        echo 'Usuário conectado!';
    }
    
    function desconectar(){
        echo 'Usuário desconectado!';
    }

    
}
