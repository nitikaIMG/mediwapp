<?php

namespace App\Exports;

use App\Models\SubcategoryModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubcategoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SubcategoryModel::where('del_status','1')->get();
    }
}
