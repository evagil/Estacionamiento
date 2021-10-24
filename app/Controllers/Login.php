<?php

namespace App\Controllers;

use App\Models\ModeloUsuario;

class Login extends BaseController
{
    public function index()
    {
        $session = session();
        $session_data = [
            'isLoggedIn' => 0,
        ];

        $session->set($session_data);

        return view('inicio/login');
    }

    public function ingresar()
    {
        $validation = \Config\Services::validation();
        $session = session();
        $usuarios = new ModeloUsuario();

        $ingreso['dni'] = $this->request->getPost('dni');
        $ingreso['clave'] = $this->request->getPost('clave');

        if ($validation->run($ingreso, 'formIngreso'))
        {
            $usuario = $usuarios->encontrarUsuarioDNI($ingreso['dni']);
            $session_data = [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'dni' => $usuario->dni,
                'rol' => $usuario->rol,
                'email' => $usuario->email,
                'clave' => $usuario->clave,
                'nombre_rol' => $usuario->nombre_rol,
                'id_usuario' => $usuario->id_usuario,
                'isLoggedIn' => 1,
            ];

            $session->set($session_data);

            return redirect()->to(base_url('usuarios/perfil'));
        }
        else
        {
            $data['validacion'] = $validation;
            return view('inicio/login', $data);
        }
    }
}