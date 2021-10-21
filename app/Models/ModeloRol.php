<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloRol extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id_rol';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Rol';
    protected $allowedFields = ['nombre_rol'];

    public function obtenerRoles()
    {
        return $this->findAll();
    }

    public function obtenerRestoRoles($id = null)
    {
        if (isset($id)) {
            return $this->where("roles.id_rol != $id")->findAll();
        }

        return $this->obtenerRoles();
    }

    public function obtenerRolDeUsuario($id)
    {
        $query = $this->select(['roles.id_rol', 'roles.nombre_rol'])->join('usuarios', 'usuarios.id_rol = roles.id_rol')->where("usuarios.id_usuario = $id");
        $rol = $query->first();
        return $rol;
    }

    public function obtenerIdRol($nombre)
    {
        return $this->where("nombre_rol like '$nombre'")->first()->id_rol;
    }
}