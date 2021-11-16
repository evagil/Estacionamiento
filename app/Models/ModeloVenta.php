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

    public function listarVentas($id = null){
        $ventas = $this->select("hora_inicio, 
            case when hora_fin is null then 'Indefinida' 
            else hora_fin end as hora_fin, 
            case when hora_fin is null then 'Contando..' 
            else cantidad_horas end as cantidad_horas,
            case when hora_fin is null then 'Contando..' 
            else monto end as monto, 
            usuarios.nombre as nombre_usuario, usuarios.apellido as apellido,  
            autos.patente as patente, 
            zonas.nombre_zona as nombre_zona, 
            case when vender = 1 then 'Si' 
            else 'No' end as venta, 
            case when pago = 1 then 'Si' 
            else 'No' end as pago")
            ->join('usuarios','ventas.id_usuario = usuarios.id_usuario')
            ->join('autos','autos.id_auto=ventas.id_auto')
            ->join('zonas_horarios','zonas_horarios.id_zona_horario=ventas.id_zona_horario')
            ->join('zonas','zonas.id_zona=zonas_horarios.id_zona')
            ->where("(now() between hora_inicio and hora_fin) 
                        OR (now() >= hora_inicio and hora_fin IS NULL)");

            if ($id === null)
            {
                return $ventas->where("ventas.id_auto", $id)->findAll();
            }
            else
            {
                return $ventas->findAll();
            }
    }

    #autos estacionados
    public function obtenerAutosDelUsuarioVentas($id_usuario)
    {
        return $this->select('usuarios.nombre as nombre_usuario, usuarios.apellido, autos.*, zonas.*, ventas.*')
        ->join('usuarios','ventas.id_usuario= usuarios.id_usuario')
        ->join('autos','autos.id_auto=ventas.id_auto')
        ->join('zonas','zonas.id_zona=ventas.id_zona_horario')
        ->where('usuarios.id_usuario', $id_usuario)
        ->findAll();       
    }

    public function bajaEstadia($id){


        $this->set('baja', 1)->where('id_usuario', $id)->update();
    
       }
}