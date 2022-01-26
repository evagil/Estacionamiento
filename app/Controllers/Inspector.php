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
    public function consultarEstadia(){
        if (session()->getFlashdata('validacion')) {
            $data['validacion'] = session()->getFlashdata('validacion');
        }

        $data['titulo'] = 'Inspeccionar';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('inspectores/consultarEstadia');
        echo view ('usuarios/perfil/perfil-footer');
    }

    public function obtenerEstadias(){
        $autos = new ModeloAuto();
        $venta = new ModeloVenta();
        $validation = \Config\Services::validation();
        $post = $this->request->getJSON(true);

        if ($validation->run($post, 'formInfraccion'))
        {
            $patente = $post['patente'];
            $auto = $autos->obtenerAutos($patente);
            $estadias = $venta->listarVentas($auto->id_auto, null, 1);

            return $this->response->setStatusCode(200)->setJSON(['estadias' => $estadias]);
        }
        else
        {
            return $this->response->setStatusCode(422, 'Datos invalidos')->setJSON(['errores' => $validation->getErrors()]);
        }
    }

    public function crearInfraccion($patente = null)
    {
        helper('form');
        if (session()->getFlashdata('validacion')) {
            $data['validacion'] = session()->getFlashdata('validacion');
        }

        if (isset($patente)) {
            $data['patente'] = $patente;
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