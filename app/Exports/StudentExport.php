<?php

namespace App\Exports;

use App\Models\CategoryModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CategoryModel::where('del_status','1')->get();
    }
}
