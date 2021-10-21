<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloUsuario extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Usuario';
    protected $allowedFields = ['nombre', 'apellido', 'dni', 'clave', 'id_rol', 'email'];

    public function encontrarUsuarioDNI($dni)
    {
        return $this->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('dni', $dni)
            ->first();
    }

    public function obtenerUsuarioPorId($id)
    {
        return $this->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('id_usuario', $id)
            ->first();
    }

    public function encontrarUsuarios()
    {
        return $this->join('roles', 'usuarios.id_rol = roles.id_rol')->findAll();
    }
}