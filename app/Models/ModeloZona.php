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
    protected $allowedFields = ['costo, f_inicio, f_fin']; //Horario de inicio y fin donde se crearon, no del estacionamiento medido y pago

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
            ->groupBy('zonas.id_zona')
            ->findAll();
    }

    public function precioEstadia($datos)
    {
        $zonaHorario = $this->obtenerZonaHorario($datos['zona'], $datos['horario']);
        $timeInicial = new Time($datos['horaInicial']);
        $timeFinal = new Time($datos['horaFinal']);
        $diferencia = $timeInicial->difference($timeFinal);
        $horas = $diferencia->getHours();
        $mins = $diferencia->getMinutes();

        if ($horas < 1)
        {
            $precio = $mins / 60 * $zonaHorario->costo;
        }
        else
        {
            $precio = $horas * $zonaHorario->costo;
        }

        return $precio;
    }
}