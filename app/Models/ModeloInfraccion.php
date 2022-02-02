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

    public function encontrarInfracciones($inspector = null, $vehiculo = null, $fechaInicio = null, $fechaFin = null)
    {
        $query = null;

        if (isset($inspector))
        {
            $query = $this->where('id_inspector', $inspector->id_usuario);
        }

        if (isset($vehiculo))
        {
            $query = $this->where('infracciones.id_auto', $vehiculo->id_auto);
        }

        if (isset($fechaInicio))
        {
            $query = $this->where('fecha >=', $fechaInicio);
        }

        if (isset($fechaFin))
        {
            $query = $this->where('fecha <=', $fechaFin);
        }

        if (!isset($query))
        {
            $query = $this->resetQuery();
        }

        return $query->select('fecha, usuarios.dni, autos.patente, descripcion')
            ->join('autos', 'infracciones.id_auto = autos.id_auto')
            ->join('usuarios', 'infracciones.id_inspector = usuarios.id_usuario')->findAll();
    }
}