<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RolGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $permisos = [
            'Administrador' => ['Administrador'],
            'Cliente' => ['Cliente'],
            'Inspector' => ['Inspector', 'Cliente'],
            'Vendedor' => ['Vendedor', 'Cliente']
        ];
        $rol = session()->get('nombre_rol');

        if (! in_array($arguments[0], $permisos[$rol])) // Si pertenece al rol correcto para acceder
        {
            return redirect()->to(base_url('usuarios/perfil'))->with('mensaje_error', 'No posee permiso para esta operacion');

        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}