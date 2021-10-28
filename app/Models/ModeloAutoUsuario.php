<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloAutoUsuario extends Model
{
    protected $table = 'usuarios_autos';
    protected $primaryKey = 'id_usuario_auto';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_usuario', 'id_auto'];

    public function vincularUsuarioYAuto($id_usuario, $id_auto)
    {
        return $this->save(['id_usuario' => $id_usuario, 'id_auto' => $id_auto]);
    }

    public function obtenerAutosDelUsuario($id_usuario)
    {
        return $this->select('patente, marca, modelo')->join('autos', 'usuarios_autos.id_auto = autos.id_auto')
            ->join('usuarios', 'usuarios_autos.id_usuario = usuarios.id_usuario')
            ->where('usuarios.id_usuario', $id_usuario)->findAll();
    }
}