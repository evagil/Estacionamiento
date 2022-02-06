<?php
namespace App\Validation;

use App\Models\ModeloZona;
use CodeIgniter\I18n\Time;
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
            ->where('baja', 0)
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

    public function mayorAHora(?string $hora, string $horaMenor): bool
    {
        $horaFinal = new Time('1-1-2021 '.$hora);
        $horaInicial = new Time('1-1-2021 '.$horaMenor);

        if ($horaFinal->isAfter($horaInicial))
            return true;
        else
            return false;
    }

    public function mayorAHoraHorarios(?string $hora, string $horaMenor): bool
    {
        $horaFinal = new Time($hora);
        $horaInicial = new Time($horaMenor);

        if ($horaFinal->isAfter($horaInicial))
            return true;
        else
            return false;
    }

    public function horaEnRango(?string $hora, string $horario): bool
    {
        $zonaHorario = new ModeloZona();
        $horarioBD = $zonaHorario->obtenerHorario($horario);
        $horaFin = new Time($horarioBD->hora_fin);
        $horaRango = new Time($hora);
        $horaInicio = new Time($horarioBD->hora_inicio);

        if (($horaRango->equals($horaInicio) || $horaRango->isAfter($horaInicio)) &&
            ($horaRango->equals($horaFin)) || $horaRango->isBefore($horaFin))
            return true;
        else
            return false;
    }

    public function diaEnRango(?string $fecha, string $horario): bool
    {
        $zonaHorario = new ModeloZona();
        $horarioBD = $zonaHorario->obtenerHorario($horario);
        $diasHabiles = explode(',', $horarioBD->dias);
        $diaDeLaSemana = Time::parse($fecha)->getDayOfWeek();

        return in_array($diaDeLaSemana, $diasHabiles);
    }

    public function diaValido(?string $fecha): bool
    {
        $hoy = new Time();
        $fechaDada = Time::parse($fecha);

        return $fechaDada->isAfter($hoy) || $fechaDada->sameAs($hoy);
    }

    public function campoUnico(?string $valor, string $datos): bool
    {
        [$tabla, $campo] = array_pad(explode(',', $datos), 2, null);
        $db = db_connect();

        $resultado = $db->table($tabla)
            ->select('1')
            ->where($campo, $valor)
            ->get()->getRow();

        return $resultado === null;
    }

    public function campoExistente(?string $valor, string $datos): bool
    {
        [$tabla, $campo] = array_pad(explode(',', $datos), 2, null);
        $db = db_connect();

        $resultado = $db->table($tabla)
            ->select('1')
            ->where($campo, $valor)
            ->get()->getRow();

        return $resultado !== null;
    }
}