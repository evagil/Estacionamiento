<?php

namespace App\Controllers;


use App\Models\ModeloAuto;
use App\Models\ModeloVenta;

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


    

}