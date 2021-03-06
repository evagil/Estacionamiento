<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ModeloZona extends Model
{
    protected $table      = 'zonas_horarios';
    protected $primaryKey = 'id_zona_horario';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\ZonaHorario';
    protected $allowedFields = ['costo','f_inicio','f_fin','id_horario','id_zona']; //Horario de inicio y fin donde se crearon, no del estacionamiento medido y pago

    public function obtenerHorariosDeLaZona($zona)
    {
        return $this->select('horarios.id_horario, dias, hora_inicio, hora_fin')
            ->join('horarios', 'zonas_horarios.id_horario = horarios.id_horario')
            ->where('zonas_horarios.id_zona', $zona)
            ->where('zonas_horarios.f_fin is null')
            ->findAll();
    }

    public function obtenerZonaHorario($zona, $horario)
    {
        return $this->select('horarios.*, zonas_horarios.*, zonas.*')
            ->join('horarios', 'zonas_horarios.id_horario = horarios.id_horario')
            ->join('zonas', 'zonas_horarios.id_zona = zonas.id_zona')
            ->where('zonas_horarios.id_zona', $zona)
            ->where('zonas_horarios.id_horario', $horario)
            ->where('zonas_horarios.f_fin is null')
            ->first();
    }

    public function obtenerHorario($horario)
    {
        return $this->select('horarios.id_horario, dias, hora_inicio, hora_fin')
            ->join('horarios', 'zonas_horarios.id_horario = horarios.id_horario')
            ->where('zonas_horarios.id_horario', $horario)
            ->groupBy('horarios.id_horario')
            ->first();
    }

    public function obtenerZonas()
    {
        return $this->select('zonas.id_zona, zonas.nombre_zona')
            ->join('zonas', 'zonas.id_zona = zonas_horarios.id_zona', 'right')
            ->where('zonas_horarios.f_fin', null)
            ->groupBy('zonas.id_zona')
            ->findAll();
    }

    public function precioEstadia($datos)
    {
        $zonaHorario = $this->obtenerZonaHorario($datos['zona'], $datos['horario']);
        $timeInicial = new Time($datos['horaInicial']);
        $timeFinal = new Time($datos['horaFinal']);
        $diferencia = $timeInicial->difference($timeFinal);
        $mins = $diferencia->getMinutes();

        $costoPorMinuto = ($mins / 60) * $zonaHorario->costo;

        return $costoPorMinuto;
    }

    public function obtenerDatosZonas(){

      return $this->select('zonas_horarios.id_zona_horario, zonas_horarios.id_zona_horario ,zonas.id_zona, zonas.nombre_zona, zonas_horarios.costo, zonas_horarios.f_inicio, zonas_horarios.f_fin, horarios.hora_inicio, horarios.hora_fin, horarios.dias')
      ->join('zonas', 'zonas.id_zona = zonas_horarios.id_zona', 'right')
      ->join('horarios', 'horarios.id_horario = zonas_horarios.id_horario')
      ->where('zonas_horarios.f_fin IS NULL')
      ->findAll();

    }

    public function obtenerDetalleZona($id)
    {
        return $this->select('zonas.id_zona, zonas_horarios.costo, horarios.dias, zonas_horarios.id_horario ,zonas_horarios.id_zona_horario, horarios.hora_inicio, horarios.hora_fin')
        ->join('zonas', 'zonas.id_zona = zonas_horarios.id_zona', 'right')
        ->join('horarios', 'horarios.id_horario = zonas_horarios.id_horario')
        ->where('zonas_horarios.id_zona_horario', $id)->first();
    }
}
