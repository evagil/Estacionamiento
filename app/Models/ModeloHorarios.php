<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ModeloHorarios extends Model
{
    protected $table      = 'horarios';
    protected $primaryKey = 'id_horario';
    protected $useAutoIncrement = true;
    protected $returnType     = 'App\Entities\Horarios';
    protected $allowedFields = ['dias','hora_inicio','hora_fin']; 






}