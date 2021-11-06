<?php

namespace App\Controllers;

use App\Models\ModeloRol;
use App\Models\ModeloUsuario;
use App\Models\ModeloAuto;
use App\Models\ModeloVenta;

class Usuario extends BaseController
{
    public function index()
    {
        $usuarios = new ModeloUsuario();
        $data['titulo'] = "Perfil";
        $data['id'] = session()->get('id_usuario');

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

    public function listar(){
        $data['titulo'] = 'Usuarios';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('usuarios/listar');
        echo view ('usuarios/perfil/perfil-footer');
    }

    public function encontrarUsuarios($id = null)
    {
        $modelo = new ModeloUsuario();

        if(isset($id)) {
            $usuarios = $modelo->obtenerUsuarioPorId($id);
        }
        else {
            $usuarios = $modelo->encontrarUsuarios();
        }

        return $this->response->setJSON($usuarios);
    }

    public function obtenerDetalleUsuario($id)
    {
        $modelo = new ModeloUsuario();

        $usuarios = $modelo->obtenerDetalleUsuario($id);

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

   

    public function formulario(){
        $data['titulo'] = 'Inspeccionar';
        echo view ('usuarios/perfil/perfil-header', $data);
        return view ('usuarios/formulario');
    }

    public function enviarPost(){
       $valor1 = $_POST['valor1'];

       $autos = new ModeloAuto();
       $venta = new ModeloVenta();
      

       $auto = $autos->obtenerAutoPorPatente($valor1);
    
       $data['ventas'] = $venta->listarVentas($auto->id_auto);

       // print_r($data['ventas']); die();

       $data['titulo'] = 'Listado de ventas del vehiculo';
       echo view ('usuarios/perfil/perfil-header', $data);
       echo view ('usuarios/listarVentas', $data);
       echo view ('usuarios/perfil/perfil-footer', $data); 
    }

   

}