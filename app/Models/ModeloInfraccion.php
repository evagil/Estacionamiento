<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloInfraccion extends Model
{
    protected $table = 'infracciones';
    protected $primaryKey = 'id_infraccion';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\Infraccion';
    protected $allowedFields = ['id_auto', 'id_inspector', 'fecha', 'descripcion'];
}