<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloAuto extends Model
{
    protected $table = 'autos';
    protected $primaryKey = 'id_auto';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\Auto';
    protected $allowedFields = ['id_auto','patente', 'marca', 'modelo'];

    public function obtenerAutoPorId($id) {
        return $this->find($id);
    }

    public function obtenerAutos($patente = null) { // Si le das una patente al metodo busca ese auto, si no busca a todos
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