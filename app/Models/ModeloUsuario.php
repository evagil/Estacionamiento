<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloUsuario extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['nombre', 'apellido', 'dni', 'clave', 'id_rol', 'email'];

    public function encontrarUsuarioDNI($dni)
    {
        return $this->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('dni', $dni)
            ->first();
    }
}