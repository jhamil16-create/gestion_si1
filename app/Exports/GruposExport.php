<?php

namespace App\Exports;

use App\Models\Grupo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GruposExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = Grupo::select('id_grupo', 'nombre', 'sigla', 'id_gestion')->get();

        return $collection->map(function ($g) {
            return [
                'id_grupo' => $g->id_grupo ?? null,
                'nombre' => $g->nombre ?? null,
                'sigla' => $g->sigla ?? null,
                'id_gestion' => $g->id_gestion ?? null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID_GRUPO',
            'NOMBRE',
            'SIGLA',
            'ID_GESTION',
        ];
    }
}
