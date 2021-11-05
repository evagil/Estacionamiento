<?php 
namespace App\Models;

use CodeIgniter\Model;

class ModeloAutosEstacionados extends Model{
    protected $table      = 'ventas';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_venta';
    protected $useAutoIncrement = true;
    #accede a las columnas
    protected $allowedFields = ['hora_inicio', 'hora_fin','cantidad_horas','monto','id_usuario','id_auto','id_zona_horario'];
    
    public function encontrarVehiculosEstacionados()
    {
        
        return $this->join('usuarios','ventas.id_usuario= usuarios.id_usuario')
        ->join('autos','autos.id_auto=ventas.id_auto')
        ->join('zonas','zonas.id_zona=ventas.id_zona_horario')->findAll();
        
    }
}