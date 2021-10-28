<?php

namespace App\Controllers;

use App\Entities\Auto;
use App\Models\ModeloAuto;
use App\Models\ModeloAutoUsuario;

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
        $autosUsuarios = new ModeloAutoUsuario();
        $validation =  \Config\Services::validation();

        $data['titulo'] = "Agregar un Vehiculo";
        $auto = new Auto($this->request->getPost());
        $data['auto'] = $auto;

        if ($validation->run($this->request->getPost(), 'formAuto')) {
            $autos->save($auto);
            return redirect()->to(base_url('usuarios/clientes/vincularVehiculo'.'/'.$auto->patente));
        }
        else {
            return redirect()->to(base_url('usuarios/clientes/agregarVehiculo'))->with('validation', $validation)->withInput();
        }
    }

    public function obtenerVehiculos($patente = null)
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

        if ($autosUsuarios->vincularUsuarioYAuto(session()->get('id_usuario'), $auto->id_auto))
        {
            return redirect()->to(base_url('usuarios/perfil'))->with('vehiculoVinculado', 'El vehiculo se vinculo a su cuenta con exito.');
        }
        else {
            return redirect()->to(base_url('usuarios/perfil'))->with('errorVinculando', 'Hubo un error para vincular el vehiculo a su cuenta.');
        }
    }
}