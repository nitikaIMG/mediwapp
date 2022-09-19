<?php

namespace App\Exports;

use App\Models\BrandModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class BrandExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BrandModel::where('del_status','1')->get();
    }
}
