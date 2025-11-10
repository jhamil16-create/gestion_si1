<?php

namespace App\Exports;

use App\Models\Docente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocentesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = Docente::select('id_docente', 'id_usuario')->get();

        return $collection->map(function ($d) {
            return [
                'id_docente' => $d->id_docente ?? null,
                'id_usuario' => $d->id_usuario ?? null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID_DOCENTE',
            'ID_USUARIO',
        ];
    }
}
