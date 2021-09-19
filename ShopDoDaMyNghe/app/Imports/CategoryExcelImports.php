<?php

namespace App\Imports;

use App\Models\CategoryModels;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryExcelImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CategoryModels([
            //
            'category_name' => $row[0],
            'category_image' => $row[1],
            'category_slug' => $row[2],
            'meta_cate_keywords' => $row[3],
            'category_desc' => $row[4],
            'category_status' => $row[5],
        ]);
    }
}
