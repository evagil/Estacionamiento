<?php

namespace App\Controllers;

use App\Models\ModeloRol;
use App\Models\ModeloUsuario;

class Usuario extends BaseController
{
    public function index()
    {
        $usuarios = new ModeloUsuario();
        $data['titulo'] = "Perfil";
        $data['usuario'] = $usuarios->obtenerUsuarioPorId(session()->get('id_usuario'));
        echo view('usuarios/perfil/perfil-header', $data);
        echo view('usuarios/detalles', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }

    public function registro() {
        helper('form');
        $usuario = new ModeloUsuario();
        $rol = new ModeloRol();
        $validation =  \Config\Services::validation();
        $data['validacion'] = null;

        $data['titulo'] = "Registro";
        $user = new \App\Entities\Usuario($this->request->getPost());
        $data['usuario'] = $user;
        $data['roles'] = $rol->obtenerRestoRoles(4);

        session()->get('nombre_rol') === 'Administrador' ? $reglas = 'formAdministrador' : $reglas = 'formUsuario';

        if ($this->request->getMethod() === 'post') {
            // El metodo deprecado es si se utiliza el parametro uppercase, proximamente se retornara solo en lowercase
            if ($validation->run($this->request->getPost(), $reglas)) {
                $usuario->save($user);

                return redirect()->to(base_url())->with('mensaje', 'Usuario creado existosamente.');
            }
            else {
                $data['validacion'] = $validation;
            }
        }

        echo view('inicio/header', $data);
        echo view('usuarios/alta', $data);
        echo view('inicio/footer');
    }

    public function altaUsuario()
    {
        helper('form');
        $usuario = new ModeloUsuario();
        $rol = new ModeloRol();
        $validation =  \Config\Services::validation();
        $data['validacion'] = null;

        $data['titulo'] = "Alta";
        $user = new \App\Entities\Usuario($this->request->getPost());
        $data['usuario'] = $user;
        $data['roles'] = $rol->obtenerRestoRoles(4);

        session()->get('nombre_rol') === 'Administrador' ? $reglas = 'formAdministrador' : $reglas = 'formUsuario';

        if ($this->request->getMethod() === 'post') {
            // El metodo deprecado es si se utiliza el parametro uppercase, proximamente se retornara solo en lowercase
            if ($validation->run($this->request->getPost(), $reglas)) {
                $usuario->save($user);
                return redirect()->to(base_url('usuarios/perfil'))->with('mensaje', 'Usuario creado existosamente.');
            }
            else {
                $data['validacion'] = $validation;
            }
        }

        echo view('usuarios/perfil/perfil-header', $data);
        echo view('usuarios/alta', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function editarUsuario($id)
    {
        helper('form');
        $usuario = new ModeloUsuario();
        $rol = new ModeloRol();
        $validation =  \Config\Services::validation();
        $data['titulo'] = "Editar";
        $data['validacion'] = null;

        $data['rolActual'] = $rol->obtenerRolDeUsuario($id);
        $data['roles'] = $rol->obtenerRestoRoles($data['rolActual']->id_rol);
        $user = new \App\Entities\Usuario($this->request->getPost());
        $data['usuario'] = $user;

        session()->get('nombre_rol') === 'Administrador' ? $reglas = 'formEditarAdministrador' : $reglas = 'formEditarUsuario';

        if ($this->request->getMethod() === 'post') {
            if ($validation->run($this->request->getPost(), $reglas)) {
                $usuario->save($user);
                return redirect()->to(base_url('usuarios/perfil'))->with('mensaje', 'Usuario editado existosamente.');
            }
            else {
                $data['validacion'] = $validation;
            }
        } else {
            $data['usuario'] = $usuario->obtenerUsuarioPorId($id);
        }

        echo view('usuarios/perfil/perfil-header', $data);
        echo view('Usuarios/editar', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function listar(){
        $modelo = new ModeloUsuario();
        $data['usuarios'] = $modelo->encontrarUsuarios();
        $data['titulo'] = 'Usuarios';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('usuarios/listar', $data);
        echo view ('usuarios/perfil/perfil-footer', $data);
    }

    public function eliminar($id){
     $modelo = new ModeloUsuario();
     $modelo->bajaUsuario($id);
     return redirect()->to(base_url('usuarios/listar'))->with('mensaje', 'Usuario eliminadoMo existosamente.');
    }

    public function reestablecerClave($id){
        $modelo = new ModeloUsuario();
        $modelo->reestablecerClave($id);
        return redirect()->to(base_url('usuarios/listar'))->with('mensaje', 'Clave reestablecida con exito.');
    }
}