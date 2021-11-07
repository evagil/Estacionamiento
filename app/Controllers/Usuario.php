<?php

namespace App\Controllers;

use App\Models\ModeloRol;
use App\Models\ModeloUsuario;
use App\Models\ModeloAuto;
use App\Models\ModeloVenta;


class Usuario extends BaseController
{
    public function perfil()
    {
        $usuarios = new ModeloUsuario();
        $data['titulo'] = "Perfil";
        $data['id'] = session()->get('id_usuario');

        echo view('usuarios/perfil/perfil-header', $data);
        echo view('usuarios/detalles', $data);
        echo view('usuarios/perfil/perfil-footer');        
    }

    public function obtenerDetalleUsuario($id)
    {
        $modelo = new ModeloUsuario();

        $usuarios = $modelo->obtenerDetalleUsuario($id);

        return $this->response->setJSON($usuarios);
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

    public function editarUsuario($id)
    {
        helper('form');
        $rol = new ModeloRol();
        $usuario = new ModeloUsuario();
        $user = $usuario->obtenerUsuarioPorId($id);

        if (session()->getFlashdata('validation')) {
            $data['validacion'] = session()->getFlashdata('validation');
        }

        $data['titulo'] = "Editar";
        $data['rolActual'] = $rol->obtenerRolDeUsuario($id);
        $data['roles'] = $rol->obtenerRestoRoles($data['rolActual']->id_rol);
        $data['usuario'] = $user;

        echo view('usuarios/perfil/perfil-header', $data);
        echo view('Usuarios/editar', $data);
        echo view('usuarios/perfil/perfil-footer');
    }
  

    public function guardarEdicion()
    {
        $usuario = new ModeloUsuario();
        $validation =  \Config\Services::validation();
        $user = new \App\Entities\Usuario($this->request->getPost());

        if ($validation->run($this->request->getPost(), 'formEditarUsuario')) {
            $usuario->save($user);
            return redirect()->to(base_url('usuarios/perfil'))->with('mensaje', 'Usuario editado existosamente.');
        }
        else {
            return redirect()->to(base_url('usuarios/modificar').'/'.$user->id_usuario)->with('validation', $validation);
        }
    }
}