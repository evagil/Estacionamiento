<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloAuto extends Model
{
    protected $table = 'autos';
    protected $primaryKey = 'id_auto';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\Auto';
    protected $allowedFields = ['patente', 'marca', 'modelo'];

    public function obtenerAutoPorId($id) {
        return $this->find($id);
    }

    public function obtenerAutos($patente = null) {
        if ($patente)
        {
            return $this->where('patente', $patente)->first();
        }
        else
        {
            return $this->findAll();
        }
    }
}