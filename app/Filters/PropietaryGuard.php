<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PropietaryGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (isset($arguments[0])) // Si el parametro de id_usuario esta seteado
        {
            $rol = session()->get('nombre_rol');
            $id = session()->get('id_usuario');
            $id_parametro = $request->getUri()->getSegment($arguments[0]);

            if ($rol !== 'Administrador' && $id !== $id_parametro) // Si no es administrador e intenta acceder a editar/eliminar/detalles de alguien que no es el usuario
            {
                return redirect()->to(base_url('usuarios/perfil'))->with('mensaje_error', 'No posee permiso para esta operacion');
            }
        }
        else
        {
            return redirect()->to(base_url('usuarios/perfil'))->with('mensaje_error', 'Faltan parametros para la operacion');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}