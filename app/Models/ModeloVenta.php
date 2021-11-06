<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloVenta extends Model
{
    protected $table      = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Venta';
    protected $allowedFields = ['hora_inicio','hora_fin','cantidad_horas','monto','id_usuario','id_auto','id_zona_horario','vender'];

   
    public function listarVentas($id){
       
        return $this->where("ventas.id_auto = $id")->findAll();
       
    }

   


}