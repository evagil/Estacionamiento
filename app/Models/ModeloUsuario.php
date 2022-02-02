<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloUsuario extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Usuario';
    protected $allowedFields = ['nombre', 'apellido', 'dni', 'clave', 'id_rol', 'email','baja'];

    public function encontrarUsuarioDNI($dni)
    {
        return $this->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('dni', $dni)
            ->where('baja', 0)
            ->first();
    }

    public function obtenerUsuarioPorId($id)
    {
        return $this->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('id_usuario', $id)
            ->where('baja', 0)
            ->first();
    }

    public function encontrarUsuarios()
    {
        return $this->join('roles', 'usuarios.id_rol = roles.id_rol')->where('baja', 0)->findAll();
    }

   public function bajaUsuario($id){

        $this->set('baja', 1)->where('id_usuario', $id)->update();

   }

    public function obtenerDetalleUsuario($id)
    {
        return $this->select('nombre, apellido, dni, email, nombre_rol')->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('id_usuario', $id)
            ->where('baja', 0)
            ->first();
    }

    public function reestablecerClave($id)
    {
        $usuario = $this->obtenerUsuarioPorId($id);

        if ($usuario->clave === '123456') {
            return true;
        }
        else {
            $usuario->clave = '123456';
            return $this->save($usuario);
        }
    }

    public function obtenerSaldoUsuario($id)
    {
        return $this->select('saldo')
            ->where('id_usuario', $id)
            ->where('baja', 0)
            ->first();
    }

    public function cargarSaldo($id, $monto)
    {
       
    }

}