<?php

namespace App\Exports;

use App\Models\CategoryModels;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExcelExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CategoryModels::all();
    }
}
