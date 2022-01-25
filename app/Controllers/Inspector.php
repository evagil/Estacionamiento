<?php

namespace App\Controllers;


use App\Entities\Auto;
use App\Entities\Infraccion;
use App\Models\ModeloAuto;
use App\Models\ModeloInfraccion;
use App\Models\ModeloVenta;
use CodeIgniter\I18n\Time;

class Inspector extends BaseController
{
    public function formulario(){
        if (session()->getFlashdata('validacion')) {
            $data['validacion'] = session()->getFlashdata('validacion');
        }

        $data['titulo'] = 'Inspeccionar';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('inspectores/formulario');
        echo view ('usuarios/perfil/perfil-footer');
    }

    public function enviarPost(){
        $autos = new ModeloAuto();
        $venta = new ModeloVenta();
        $valor1 = $_POST['valor1'];
        $validation = \Config\Services::validation();

        if ($validation->run(['patente' => $valor1], 'patenteInspeccion'))
        {
            $auto = $autos->obtenerAutos($valor1);

           if($auto){


            $data['ventas'] = $venta->listarVentas($auto->id_auto, null, 1);

            $data['titulo'] = 'Listado de ventas del vehiculo';
            echo view ('usuarios/perfil/perfil-header', $data);
            echo view ('inspectores/listarVentas', $data);
            echo view ('usuarios/perfil/perfil-footer');
              }
             else{
            return redirect()->to(base_url('usuarios/inspectores/formulario'))->with('mensaje_error', 'No existe la patente ingresada en el sistema');
                }
        }
        else
        {
            return redirect()->to(base_url('usuarios/inspectores/formulario'))->with('validacion', $validation);
        }
    }

    public function crearInfraccion()
    {
        helper('form');
        if (session()->getFlashdata('validacion')) {
            $data['validacion'] = session()->getFlashdata('validacion');
        }

        if (session()->getFlashdata('patente')) {
            $data['patente'] = session()->getFlashdata('patente');
        }

        $data['titulo'] = "Crear Infraccion";
        echo view('usuarios/perfil/perfil-header', $data);
        echo view('inspectores/crearInfraccion');
        echo view('usuarios/perfil/perfil-footer');
    }

    public function guardarInfraccion()
    {
        $infracciones = new ModeloInfraccion();
        $validation =  \Config\Services::validation();

        if ($validation->run($this->request->getPost(), 'formInfraccion')) {
            $patente = $this->request->getPost()['patente'];
            $descripcion = $this->request->getPost()['descripcion'];

            $autos = new ModeloAuto();
            $auto = $autos->obtenerAutos($patente);

            $inspector = session()->get('id_usuario');
            $infraccion = new Infraccion([
                'id_auto' => $auto->id_auto,
                'id_inspector' => $inspector,
                'fecha' => Time::now(),
                'descripcion' => $descripcion
            ]);

            $infracciones->save($infraccion);

            return redirect()->to(base_url('usuarios/perfil'))->with('mensaje', 'Infraccion creada exitosamente.');
        }
        else {
            return redirect()->to(base_url('usuarios/inspectores/infraccion'))->with('validacion', $validation)->withInput();
        }
    }

    public function obtenerAuto($patente)
    {
        $autos = new ModeloAuto();
        return $this->response->setJSON(['auto' => $autos->obtenerAutos($patente)]);
    }

    public function guardarVehiculo()
    {
        $autos = new ModeloAuto();
        $validation =  \Config\Services::validation();
        $auto = new Auto($this->request->getPost());

        if ($validation->run($this->request->getPost(), 'formAuto')) {
            $autos->save($auto);
            return $this->response->setStatusCode(200, 'Vehiculo creado');
        }
        else {
            return $this->response->setStatusCode(500, 'Vehiculo no creado')->setJSON(json_encode($validation->getErrors()));
        }
    }
}