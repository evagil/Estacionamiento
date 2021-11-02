<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloUsuario extends Model
{
    protected $table      = 'autos';
    protected $primaryKey = 'id_auto';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Vehiculo';
    protected $allowedFields = ['patente', 'marca', 'modelo'];

    public function encontrarVehiculoId($idVehiculo)
    {
        return $this->join('usuarios_autos', 'usuarios_autos.id_auto = autos.id_auto')
            ->where('id_auto', $idVehiculo)
            ->where('baja', 0)
            ->first();
    }

    public function obtenerVehiculoPorId($idVehiculo)
    {
        return $this->join('usuarios_autos', 'usuarios_autos.id_auto = autos.id_auto')
            ->where('id_auto', $idVehiculo)
            ->where('baja', 0)
            ->first();
    }

    public function encontrarVehiculo()
    {
        return $this->join('usuarios_autos', 'usuarios_autos.id_auto = autos.id_auto')->where('baja', 0)->findAll();
    }

   public function bajaVehiculo($idVehiculo){


    $this->set('baja', 1)->where('id_auto', $idVehiculo)->update();


             
   }


}