<?php

namespace App\Exports;

use App\Models\ProductModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductModel::where('del_status','1')->get();
    }
}
