<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ModeloZonaSinID extends Model
{
    protected $table      = 'zonas_horarios';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\ZonaHorarioSinID';
    protected $allowedFields = ['costo','f_inicio','f_fin','id_horario']; 


}