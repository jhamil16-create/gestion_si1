<?php

namespace App\Exports;

use App\Models\Materia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MateriasExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = Materia::select('sigla', 'nombre')->get();

        return $collection->map(function ($m) {
            return [
                'sigla' => $m->sigla ?? null,
                'nombre' => $m->nombre ?? null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SIGLA',
            'NOMBRE',
        ];
    }
}
