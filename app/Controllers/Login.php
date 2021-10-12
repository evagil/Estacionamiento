<?php

namespace App\Controllers;

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

        $ingreso['dni'] = $this->request->getPost('dni');
        $ingreso['clave'] = $this->request->getPost('clave');

        if ($validation->run($ingreso, 'formIngreso'))
        {
            $session_data = [
                'dni' => $ingreso['dni'],
                'clave' => $ingreso['clave'],
                'isLoggedIn' => 1,
            ];

            $session->set($session_data);

            header('Location: usuarios/perfil');
            die();
        }
        else
        {
            $data['validacion'] = $validation;
            return view('inicio/login', $data);
        }
    }
}