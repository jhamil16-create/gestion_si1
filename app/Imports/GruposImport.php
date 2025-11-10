<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class GruposImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        DB::table('grupo')->updateOrInsert(
            ['id_grupo' => $row['id_grupo'] ?? null],
            [
                'id_grupo' => $row['id_grupo'] ?? null,
                'nombre' => $row['nombre'] ?? null,
                'sigla' => $row['sigla'] ?? null,
                'id_gestion' => $row['id_gestion'] ?? null,
                'estado' => $row['estado'] ?? null,
            ]
        );

        return null;
    }
}
