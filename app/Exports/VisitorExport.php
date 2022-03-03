<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
class VisitorExport implements FromQuery, WithHeadings
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $columns = ['ip', 'os', 'browser', 'device'];


    public function query()
    {
        return Visitor::query()->select($this->columns);
    }


    public function headings():array
    {
        return $this->columns;
    }
}
