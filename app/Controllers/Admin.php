<?php

namespace App\Controllers;

use App\Models\ModeloRol;
use App\Models\ModeloUsuario;
use App\Models\ModeloVenta;
use App\Models\ModeloZona;


class Admin extends BaseController
{
    public function altaUsuario()
    {
        helper('form');
        $rol = new ModeloRol();

        if (session()->getFlashdata('validation')) {
            $data['validacion'] = session()->getFlashdata('validation');
        }

        $data['titulo'] = "Alta";
        $data['roles'] = $rol->obtenerRestoRoles(4);
        var_dump($data);
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
            return redirect()->to(base_url('usuarios/administrador/altaUsuario'))->with('validation', $validation)->withInput();
        }
    }

    public function listarUsuarios(){
        $data['titulo'] = 'Usuarios';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('administrador/listar');
        echo view ('usuarios/perfil/perfil-footer');
    }

    public function listarZonas(){
        $data['titulo'] = 'Zonas';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('administrador/listarZonas');
        echo view ('usuarios/perfil/perfil-footer');
    }

    public function obtenerZonas(){
        $modelo = new ModeloZona();
        $zonas = $modelo->obtenerDatosZonas();
        return $this->response->setJSON($zonas);
    }

   public function obtenerDetalleZona($id){
    $modelo = new ModeloZona();

    $zonas = $modelo->obtenerDetalleZona($id);

    return $this->response->setJSON($zonas);
   }


   public function editarZonas($id){
    helper('form');
    $modelo = new ModeloZona();
 
    $zona = $modelo->obtenerDetalleZona($id);

    if (session()->getFlashdata('validation')) {
        $data['validacion'] = session()->getFlashdata('validation');
    }

    $data['titulo'] = "Editar";
    $data['zonas'] = $zona;


   // print_r($zona);

    echo view('usuarios/perfil/perfil-header', $data);
    echo view('administrador/editarZonas', $data);
    echo view('usuarios/perfil/perfil-footer');
  
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

    

    public function eliminar($id){
        $modelo = new ModeloUsuario();
        $modelo->bajaUsuario($id);
        return redirect()->to(base_url('usuarios/administrador/listadoUsuarios'))->with('mensaje', 'Usuario eliminado existosamente.');
    }

    public function reestablecerClave($id){
        $modelo = new ModeloUsuario();
        $modelo->reestablecerClave($id);
        return redirect()->to(base_url('usuarios/administrador/listadoUsuarios'))->with('mensaje', 'Clave reestablecida con exito.');
    }

    public function listarVehiculosEstacionados() {
        $data['titulo'] = "Listado de Vehiculos Estacionados";
        echo view('usuarios/perfil/perfil-header', $data);
        echo view('administrador/listarVehiculosEstacionados');
        echo view('usuarios/perfil/perfil-footer');
    }

    public function obtenerVehiculosEstacionados(){
        $ventas = new ModeloVenta();
        $autos = $ventas->listarVentas(null, null, 1);
        return $this->response->setJSON($autos);
    }

    
    


}