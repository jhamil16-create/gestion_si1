<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class MateriasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Usamos updateOrInsert para evitar problemas con fillable
        DB::table('materia')->updateOrInsert(
            ['sigla' => $row['sigla'] ?? null],
            [
                'sigla' => $row['sigla'] ?? null,
                'nombre' => $row['nombre'] ?? null,
                'descripcion' => $row['descripcion'] ?? null,
                'creditos' => $row['creditos'] ?? null,
                'estado' => $row['estado'] ?? null,
            ]
        );

        return null;
    }
}
