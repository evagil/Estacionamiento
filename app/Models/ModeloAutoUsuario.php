<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloAutoUsuario extends Model
{
    protected $table = 'usuarios_autos';
    protected $primaryKey = 'id_usuario_auto';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_usuario', 'id_auto'];

    public function vincularUsuarioYAuto($id_usuario, $id_auto, &$errores)
    {
        try {
            return $this->save(['id_usuario' => $id_usuario, 'id_auto' => $id_auto]);
        }
        catch (\Exception $e) {
            $errores = $e->getCode();
            return false;
        }
    }

    public function obtenerAutosDelUsuario($id_usuario, $patente = null)
    {
        if ($patente) {
            return $this->select('patente, marca, modelo')->join('autos', 'usuarios_autos.id_auto = autos.id_auto')
                ->join('usuarios', 'usuarios_autos.id_usuario = usuarios.id_usuario')
                ->where('usuarios.id_usuario', $id_usuario)->where('autos.patente', $patente)->first();
        }
        return $this->select('patente, marca, modelo')->join('autos', 'usuarios_autos.id_auto = autos.id_auto')
            ->join('usuarios', 'usuarios_autos.id_usuario = usuarios.id_usuario')
            ->where('usuarios.id_usuario', $id_usuario)->findAll();
    }
}