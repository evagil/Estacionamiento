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

    public function listarVentas($idAuto = null, $idUsuario = null, $pendiente = 0){ // pendiente en 1, devuelve los activos y en 0 ambos
        $ventas = $this->select("ventas.id_venta, hora_inicio, hora_fin, 
            case when hora_fin is null then 'Contando..' 
            else cantidad_horas end as cantidad_horas,
            case when hora_fin is null then 'Contando..' 
            else monto end as monto, 
            concat(usuarios.nombre, ' ', usuarios.apellido) as nombre_usuario,  
            autos.patente as patente, 
            zonas.nombre_zona as nombre_zona, 
            case when vender = 1 then 'Si' 
            else 'No' end as venta, 
            case when pago = 1 then 'Si' 
            else 'No' end as pago, 
            case when now() >= hora_inicio and hora_fin is null or (hora_fin is not null and now() between hora_inicio and hora_fin) then 'Activo' 
                when now() < hora_inicio then 'Pendiente'
                when hora_fin is not null and now() >= hora_fin then 'Finalizado'  
                else 'Desconocido' end as estado")
            ->join('usuarios','ventas.id_usuario = usuarios.id_usuario')
            ->join('autos','autos.id_auto=ventas.id_auto')
            ->join('zonas_horarios','zonas_horarios.id_zona_horario=ventas.id_zona_horario')
            ->join('zonas','zonas.id_zona=zonas_horarios.id_zona');

        if ($idAuto !== null)
        {
            $ventas->where("ventas.id_auto", $idAuto);
        }

        if ($idUsuario !== null)
        {
            $ventas->where("ventas.id_usuario", $idUsuario);
        }

        if ($pendiente === 1)
        {
            $ventas->where('(now() between hora_inicio and hora_fin OR now() >= hora_inicio and hora_fin IS NULL)');
        }

        return $ventas->findAll();
    }

    public function bajaEstadia($id, $precio, $hora_fin){
        $this->set([
            'hora_fin' => $hora_fin,
            'monto' => $precio
        ])->where('id_venta', $id)->update();
    }

    public function obtenerzonaHoraria( $idVenta){

        return $this->select ('id_zona, id_horario, hora_inicio, now() as hora_fin')
        ->where ('id_venta', $idVenta )
        -> join ('zonas_horarios','zonas_horarios.id_zona_horario=ventas.id_zona_horario')
        -> first();
    }

    public function crearEstadia($venta, &$errores)
    {
        try {
            return $this->save($venta);
        }
        catch (\Exception $e) {
            $errores = $e->getMessage();
            return false;
        }
    }

  public function pagarEstadia($id_venta)
    {
        $modeloUsuario = new ModeloUsuario();
        $venta = $this->find($id_venta);

        $modeloUsuario->pagarMonto($venta->id_usuario, $venta->monto);

        if (!$this->update($id_venta, ['pago' => 1]))
        {
            throw new \Exception('Error desconocido.');
        }
    }

    public function listarVentaVendedor($id){ 
        return  $this->select("ventas.id_venta, hora_inicio, hora_fin, 
            case when hora_fin is null then 'Contando..' 
            else cantidad_horas end as cantidad_horas,
            case when hora_fin is null then 'Contando..' 
            else monto end as monto, 
            concat(usuarios.nombre, ' ', usuarios.apellido) as nombre_usuario,  
            autos.patente as patente, 
            zonas.nombre_zona as nombre_zona, 
            case when vender = 1 then 'Si' 
            else 'No' end as venta, 
            case when pago = 1 then 'Si' 
            else 'No' end as pago, 
            case when now() >= hora_inicio and hora_fin is null or (hora_fin is not null and now() between hora_inicio and hora_fin) then 'Activo' 
                when now() < hora_inicio then 'Pendiente'
                when hora_fin is not null and now() >= hora_fin then 'Finalizado'  
                else 'Desconocido' end as estado")
            ->join('usuarios','ventas.id_usuario = usuarios.id_usuario')
            ->join('autos','autos.id_auto=ventas.id_auto')
            ->join('zonas_horarios','zonas_horarios.id_zona_horario=ventas.id_zona_horario')
            ->join('zonas','zonas.id_zona=zonas_horarios.id_zona')
            ->where("ventas.id_usuario",$id)
        ->findAll();

    }

}