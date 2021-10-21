<?php

namespace App\Controllers;

use  App\Models\ModeloUsuario;

class Usuario extends BaseController
{
    public function index()
    {
        return view('usuarios/perfil/perfil');
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to(base_url());
       
    }

    

    public function listar(){
        $modelo = new ModeloUsuario();
        $usuarios = $modelo -> encontrarUsuarios();
        $data['usuarios'] = $usuarios;
        echo view ('consultas/listar', $data);
    }
}