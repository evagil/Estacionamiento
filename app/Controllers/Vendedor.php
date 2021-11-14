<?php

namespace App\Controllers;


use App\Entities\Auto;
use App\Models\ModeloAuto;
use App\Models\ModeloVenta;
use App\Models\ModeloZona;
use CodeIgniter\I18n\Time;

class Vendedor extends BaseController
{
    public function crearEstadia()
    {
        helper('form');
        $data['titulo'] = 'Vender Estadia';

        if (session()->getFlashdata('validation'))
        {
            $data['validacion'] = session()->getFlashdata('validation');
        }

        echo view('usuarios/perfil/perfil-header', $data);
        echo view('vendedores/crearEstadia', $data);
        echo view('usuarios/perfil/perfil-footer');
    }

    public function guardarEstadia()
    {
        $validation = \Config\Services::validation();
        if ($validation->run($this->request->getPost(), 'formVentaVendedor'))
        {
            /*
             * Comprobar si la patente existe o no.
             * Si no existe vehículo con esa patente, se crea y vincula a la estadía.
             * Si existe, se vincula a la estadía.
             * En la base de datos habría que hacer un trigger para que calcule el precio, porque
             * esta sería una estadía que tiene fecha de fin y debería ingresarla como pagada.
            */

            $ventas = new ModeloVenta();
            $autos = new ModeloAuto();
            $zonas = new ModeloZona();
            $post = $this->request->getPost();
            $auto = $autos->obtenerAutos($post['patente']);
            $precio = $zonas->precioEstadia($post);
            $zonaHorario = $zonas->obtenerZonaHorario($post['zona'], $post['horario']);

            if ($auto)
            {
                $venta = new \App\Entities\Venta([
                    'hora_inicio' => Time::parse($post['fecha'].' '.$post['horaInicial']),
                    'hora_fin' => Time::parse($post['fecha'].' '.$post['horaFinal']),
                    'monto' => $precio,
                    'id_usuario' => session()->get('id_usuario'),
                    'id_auto' => $auto->id_auto,
                    'id_zona_horario' => $zonaHorario->id_zona_horario,
                    'vender' => 1,
                    'pago' => 1
                ]);

                if ($ventas->save($venta))
                {
                    return redirect()->to(base_url('usuarios/perfil'))->with('mensaje', 'Venta existosa.');
                }
                else
                {
                    print_r('No existe el auto wacim'); die();
                }
            }
        }
        else
        {
            return redirect()->to(base_url('usuarios/vendedores/vender'))->with('validation', $validation)->withInput();
        }
    }

    public function precioEstadia()
    {
        $zonas = new ModeloZona();
        $datos = [
            'zona' => $this->request->getHeaderLine('zona'),
            'horario' => $this->request->getHeaderLine('horario'),
            'fecha' => $this->request->getHeaderLine('fecha'),
            'horaInicial' => $this->request->getHeaderLine('horaInicial'),
            'horaFinal' => $this->request->getHeaderLine('horaFinal')
        ];

        $validation = \Config\Services::validation();
        if ($validation->run($datos, 'formPrevisualizacion'))
        {
            return $this->response->setJSON(['precio' => $zonas->precioEstadia($datos)]);
        }
        else
        {
            return $this->response->setJSON(['validacion' => $validation->getErrors()]);
        }
    }

    public function obtenerZonas()
    {
        $zonas = new ModeloZona();
        return $this->response->setJSON(['zonas' => $zonas->obtenerZonas()]);
    }

    public function obtenerHorariosZona()
    {
        $zonas = new ModeloZona();
        $zona = $this->request->getHeaderLine('zona');
        $horario = $this->request->getHeaderLine('horario');

        if($zona)
        {
            return $this->response->setJSON(['horarios' => $zonas->obtenerHorariosDeLaZona($zona)]);
        }

        if($horario)
        {
            return $this->response->setJSON(['horario' => $zonas->obtenerHorario($horario)]);
        }
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