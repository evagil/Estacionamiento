<?php
namespace App\Validation;

use Config\Database;

class IngresoRules {
    public function existeUsuario(?string $valor, string $campo, array $data): bool
    {
        // Grab any data for exclusion of a single row.
        [$campo, $campoComparar, $valorComparar] = array_pad(explode(',', $campo), 3, null);

        // Break the table and field apart
        sscanf($campo, '%[^.].%[^.]', $table, $campo);

        $db = Database::connect($data['DBGroup'] ?? null);

        $row = $db->table($table)
            ->select('1')
            ->where($campo, $valor)
            ->limit(1);

        if (! empty($campoComparar) && ! empty($valorComparar) && ! preg_match('/^\{(\w+)\}$/', $valorComparar)) {
            $row = $row->where("{$campoComparar} !=", $valorComparar);
        }

        return $row->get()->getRow() !== null;
    }

    public function coincideClave(?string $clave, string $campos, array $data): bool
    {
        // Grab any data for exclusion of a single row.
        [$campo, $dni] = array_pad(explode(',', $campos), 2, null);

        // Break the table and field apart
        sscanf($campo, '%[^.].%[^.]', $table, $campo);

        $db = Database::connect($data['DBGroup'] ?? null);

        $row = $db->table($table)
            ->select('clave')
            ->where('dni', $dni)
            ->limit(1);

        if (!empty($clave)) {
            $row = $row->where("clave =", $clave);
        }

        return $row->get()->getRow() !== null;
    }
}