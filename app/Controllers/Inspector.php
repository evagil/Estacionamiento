<?php

namespace App\Controllers;


use App\Models\ModeloAuto;
use App\Models\ModeloVenta;

class Inspector extends BaseController
{
    public function formulario(){
        $data['titulo'] = 'Inspeccionar';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('usuarios/formulario');
        echo view ('usuarios/perfil/perfil-footer');
    }

    public function enviarPost(){
        $valor1 = $_POST['valor1'];

        $autos = new ModeloAuto();
        $venta = new ModeloVenta();

        $auto = $autos->obtenerAutos($valor1);

        $data['ventas'] = $venta->listarVentas($auto->id_auto, null, 1);

        $data['titulo'] = 'Listado de ventas del vehiculo';
        echo view ('usuarios/perfil/perfil-header', $data);
        echo view ('usuarios/listarVentas', $data);
        echo view ('usuarios/perfil/perfil-footer');
    }


    

}