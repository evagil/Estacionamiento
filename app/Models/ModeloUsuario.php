<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloUsuario extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Usuario';
    protected $allowedFields = ['nombre', 'apellido', 'dni', 'clave', 'id_rol', 'email','baja', 'saldo'];

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
      $saldo = $this->obtenerSaldoUsuario($id);
      $suma = $saldo->saldo + $monto;

      if ($suma >= 99999999)
      {
          throw new \Exception("Se excedio el monto permitido.");
      }

      $resultado = $this->set('saldo', $suma)->where('id_usuario', $id)->update();

      if (!$resultado)
      {
        throw new \Exception("No se pudo cargar saldo");
      }
    }

    public function pagarMonto($id, $monto)
    {
        $usuario = $this->find($id);
        $saldo = $usuario->saldo - $monto;

        if ($saldo < 0)
        {
            throw new \Exception('No tiene saldo suficiente.');
        }

        if (!$this->update($usuario->id_usuario, ['saldo' => $saldo]))
        {
            throw new \Exception('Error desconocido.');
        }
    }
}