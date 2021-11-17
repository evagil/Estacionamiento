<?php

namespace App\Controllers;

use App\Entities\Auto;
use App\Models\ModeloAuto;
use App\Models\ModeloAutoUsuario;
use App\Models\ModeloVenta;
use App\Models\ModeloZona;

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
    }

    public function finalizarEstadia(){

        $modeloZona = new ModeloZona();
        $idVenta = $this->request->getHeaderLine('idVenta');

        $modeloVenta = new ModeloVenta();
        $zonahorario = $modeloVenta -> obtenerzonaHoraria( $idVenta);
       
        $datos = ['zona'=> $zonahorario ->id_zona,
            'horario'=> $zonahorario ->id_horario, 
            'horaInicial'=> $zonahorario -> hora_inicio,
            'horaFinal'=> $zonahorario ->hora_fin];

        $precio = $modeloZona->precioEstadia($datos);

        $modeloVenta->bajaEstadia($idVenta, $precio);
        #ver en mis-vehiculos-estacionados


        return redirect()->to(base_url('usuarios/clientes/verMisEstadias'))->with('mensaje', 'Venta finalizada existosamente.');
    }
    
    public function guardarEstadia(){
       // $data['titulo'] = "Agregar un Vehiculo";
        //echo view('usuarios/perfil/perfil-header', $data);
        //echo view('usuarios/activarEstadia', $data);
        //echo view('usuarios/perfil/perfil-footer');

      

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
                    'vender' => 0,
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
           
            return redirect()->to(base_url('usuarios/clientes/crear'))->with('validation', $validation)->withInput();
         }


    }


    public function crearEstadia()
    {
        helper('form');
        $data['titulo'] = 'Activar Estadia';

       // if (session()->getFlashdata('validation'))
        //{
         //   $data['validacion'] = session()->getFlashdata('validation');
        //}

        echo view('usuarios/perfil/perfil-header', $data);
        echo view('clientes/activarEstadia', $data);
        echo view('usuarios/perfil/perfil-footer');
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


    

    public function obtenerVehiculosDelCliente()
    {
        $autos = new ModeloAutoUsuario();
        return $this->response->setJSON(['autos' => $autos->obtenerAutosDelUsuario(session()->get('id_usuario'))]);
    }


  
}