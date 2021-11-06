<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloAuto extends Model
{
    protected $table = 'autos';
    protected $primaryKey = 'id_auto';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\Auto';
    protected $allowedFields = ['id_auto','patente', 'marca', 'modelo'];

    public function obtenerAutoPorId($id) {
        return $this->find($id);
    }

    public function obtenerAutos($patente = null) {
        if ($patente)
        {
            return $this->where('patente', $patente)->first();
        }
        else
        {
            return $this->findAll();
        }
    }

    public function obtenerAutoPorPatente($patente){
       // print_r($patente);
      //  print_r($this->where($patente, 'autos.patente')->first()->id_auto);
       //return $this->where("patente like '$patente'")->first()->id_auto;
 
       $query = $this->where("autos.patente like '$patente'");
       $auto = $query->first();
       return $auto;

    }

    // estas 2 no van
    public function obtenerRolDeUsuario($id)
    {
        $query = $this->select(['roles.id_rol', 'roles.nombre_rol'])->join('usuarios', 'usuarios.id_rol = roles.id_rol')->where("usuarios.id_usuario = $id");
        $rol = $query->first();
        return $rol;
    }

    public function listarVentass($id){
       
        return $this->select('ventas.monto', 'ventas.id_venta')
        ->join('ventas', 'ventas.id_auto = autos.id_auto')
        ->where("ventas.id_auto = $id")
        ->findAll();
       
    }

    public function listarVentas($id){
       
        return $this->select('ventas.monto', 'ventas.id_venta','ventas.hora_inicio','ventas.hora_fin','ventas.cantidad.horas')
        ->join('ventas', 'autos.id_auto = ventas.id_auto')
        ->where("ventas.id_auto = $id")
        ->findAll();
       
    }

}