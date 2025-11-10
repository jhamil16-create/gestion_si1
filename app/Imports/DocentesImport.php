<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class DocentesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Insertar o actualizar docente y mantener unión con tabla usuario
        DB::table('docente')->updateOrInsert(
            ['id_docente' => $row['id_docente'] ?? null],
            [
                'id_docente' => $row['id_docente'] ?? null,
                'id_usuario' => $row['id_usuario'] ?? null,
                'especialidad' => $row['especialidad'] ?? null,
                'estado' => $row['estado'] ?? null,
            ]
        );

        // Si vienen datos de usuario (nombre,email) se podrían insertar/actualizar en tabla usuario
        if (!empty($row['nombre']) || !empty($row['email'])) {
            DB::table('usuario')->updateOrInsert(
                ['id_usuario' => $row['id_usuario'] ?? null],
                [
                    'nombre' => $row['nombre'] ?? null,
                    'email' => $row['email'] ?? null,
                ]
            );
        }

        return null;
    }
}
