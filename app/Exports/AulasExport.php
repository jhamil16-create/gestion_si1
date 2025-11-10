<?php

namespace App\Exports;

use App\Models\Aula;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AulasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Aula::select('id_aula', 'tipo')->get()->map(function($a) {
            return [
                'id_aula' => $a->id_aula,
                'tipo' => $a->tipo,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID_AULA',
            'TIPO',
        ];
    }
}