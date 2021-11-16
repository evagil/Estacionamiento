<?php

namespace App\Controllers;

use App\Entities\Auto;
use App\Models\ModeloAuto;
use App\Models\ModeloAutoUsuario;
use App\Models\ModeloVenta;

class Cliente extends BaseController
{
    public function index()
    {
        $data['titulo'] = "Listado de Vehiculos";
        echo view('usuarios/perfil/perfil-header', $data);
        echo view('clientes/lista-vehiculos');
        echo view('usuarios/perfil/perfil-footer');
    }

    public function agregarVehiculo()
    {
        if (session()->getFlashdata('validation')) {
            $data['validacion'] = session()->getFlashdata('validation');
        }

        $data['titulo'] = "Agregar un Vehiculo";
        echo view('usuarios/perfil/perfil-header', $data);
        echo view('clientes/agregar-vehiculo', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function guardarVehiculo()
    {
        $autos = new ModeloAuto();
        $validation =  \Config\Services::validation();
        $auto = new Auto($this->request->getPost());

        if ($validation->run($this->request->getPost(), 'formAutoVincular')) {
            $autos->save($auto);
            return redirect()->to(base_url('usuarios/clientes/vincularVehiculo').'/'.$auto->patente);
        }
        else {
            return redirect()->to(base_url('usuarios/clientes/agregarVehiculo'))->with('validation', $validation)->withInput();
        }
    }

    public function obtenerVehiculo($patente)
    {
        $autos = new ModeloAuto();
        $auto = $autos->obtenerAutos($patente);
        return $this->response->setJSON($auto);
    }

    public function obtenerVehiculos()
    {
        $autos = new ModeloAutoUsuario();
        $id_usuario = session()->get('id_usuario');
        $auto = $autos->obtenerAutosDelUsuario($id_usuario);
        return $this->response->setJSON($auto);
    }

    public function vincularVehiculo($patente)
    {
        $autos = new ModeloAuto();
        $autosUsuarios = new ModeloAutoUsuario();
        $auto = $autos->obtenerAutos($patente);
        $errores = null;

        if ($autosUsuarios->vincularUsuarioYAuto(session()->get('id_usuario'), $auto->id_auto, $errores))
        {
            return redirect()->to(base_url('usuarios/perfil'))->with('mensaje', 'El vehiculo se vinculo a su cuenta con exito.');
        }
        else {
            $mensaje = "desconocido";

            if ($errores === 1062) {
                $mensaje = "El vehiculo ya esta asociado a su usuario.";
            }

            return redirect()->to(base_url('usuarios/perfil'))->with('mensaje_error', 'Hubo un error para vincular el vehiculo a su cuenta: '.$mensaje);
        }
    }

    # ver vehiculos estacionados
    public function verMisEstadias(){
        $data['titulo'] = "Mis Estadias";
        echo view('usuarios/perfil/perfil-header', $data);
        echo view('clientes/misVehiculosEstacionados', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function obtenerEstadiaVehiculo()
    {    
        $auto = new ModeloVenta();
        $id_usuario = session()->get('id_usuario');
        $automovil = $auto->listarVentas(null, $id_usuario);
        return $this->response->setJSON($automovil);       
    
    }

    public function verFinalizarEstadia(){
        $data['titulo'] = "Finalizar Estadia";
        echo view('usuarios/perfil/perfil-header', $data);
        echo view('clientes/finalizarEstadia', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function finalizarEstadiaVehiculo(){

        $autos = new ModeloAutoUsuario();
        $id_usuario = session()->get('id_usuario');
        $auto = $autos->obtenerAutosDelUsuario($id_usuario);
               
    public function finalizarEstadia(){
        $modelo = new ModeloVenta();
        $idVenta = $this->request->getHeaderLine('idVenta');
        $modelo->bajaEstadia($idVenta);
        #ver en mis-vehiculos-estacionados
        return redirect()->to(base_url('usuarios/clientes/listadoUsuarios'))->with('mensaje', 'Venta finalizada existosamente.');
    }

  
}