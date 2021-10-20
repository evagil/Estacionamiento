<?php

namespace App\Controllers;

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
}