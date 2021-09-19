<?php

namespace App\Imports;

use App\Models\ProductModels;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductExcelImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
          return new ProductModels([
           'product_name' => $row[0], 
           'product_slug' => $row[1],
           'category_id' => $row[2],
           'product_cost' => $row[3],
           'product_price' => $row[4],
           'product_image' => $row[5],
           'product_quantity' => $row[6],
           'product_sold' => $row[7],
           'meta_product_keywords' => $row[8],
           'product_desc' => $row[9],
           'product_content' => $row[10],
           'product_status' => $row[11],
        ]);
    }
}
