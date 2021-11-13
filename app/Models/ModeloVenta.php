<?php

namespace App\Models;
use CodeIgniter\Model;

class ModeloVenta extends Model
{
    protected $table      = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Venta';
    protected $allowedFields = ['hora_inicio','hora_fin','cantidad_horas','monto','id_usuario','id_auto','id_zona_horario','vender', 'pago'];

    public function listarVentas($id){
        return $this->where("ventas.id_auto = $id")->findAll();
    }

    public function encontrarVehiculosEstacionados()
    {
        return $this->select('usuarios.nombre as nombre_usuario, usuarios.apellido, autos.*, zonas.*, ventas.*')
            ->join('usuarios','ventas.id_usuario= usuarios.id_usuario')
            ->join('autos','autos.id_auto=ventas.id_auto')
            ->join('zonas','zonas.id_zona=ventas.id_zona_horario')->findAll();
    }
}