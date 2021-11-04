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
        $rol = new ModeloRol();

        if (session()->getFlashdata('validation')) {
            $data['validacion'] = session()->getFlashdata('validation');
        }

        $data['titulo'] = "Registro";

        echo view('inicio/header', $data);
        echo view('usuarios/alta', $data);
        echo view('inicio/footer');
    }

    public function guardarRegistro()
    {
        $usuarios = new ModeloUsuario();
        $validation =  \Config\Services::validation();

        $usuario = new \App\Entities\Usuario($this->request->getPost());

        if ($validation->run($this->request->getPost(), 'formUsuario')) {
            $usuarios->save($usuario);
            return redirect()->to(base_url())->with('mensaje', 'Usuario creado existosamente.');
        }
        else {
            return redirect()->to(base_url('registro'))->with('validation', $validation)->withInput();
        }
    }

    public function altaUsuario()
    {
        helper('form');
        $rol = new ModeloRol();

        if (session()->getFlashdata('validation')) {
            $data['validacion'] = session()->getFlashdata('validation');
        }

        $data['titulo'] = "Alta";
        $data['roles'] = $rol->obtenerRestoRoles(4);

        echo view('usuarios/perfil/perfil-header', $data);
        echo view('usuarios/alta', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function guardarAlta()
    {
        $usuario = new ModeloUsuario();
        $validation =  \Config\Services::validation();
        $user = new \App\Entities\Usuario($this->request->getPost());

        if ($validation->run($this->request->getPost(), 'formAdministrador')) {
            $usuario->save($user);
            return redirect()->to(base_url('usuarios/perfil'))->with('mensaje', 'Usuario creado existosamente.');
        }
        else {
            return redirect()->to(base_url('usuarios/alta'))->with('validation', $validation)->withInput();
        }
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
        $data['titulo'] = 'Usuarios';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('usuarios/listar');
        echo view ('usuarios/perfil/perfil-footer');
    }

    public function encontrarUsuarios()
    {
        $modelo = new ModeloUsuario();
        $usuarios = $modelo->encontrarUsuarios();
        return $this->response->setJSON($usuarios);
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