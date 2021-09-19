<?php

namespace App\Exports;

use App\Models\ProductModels;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExcelExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductModels::all();
    }
}