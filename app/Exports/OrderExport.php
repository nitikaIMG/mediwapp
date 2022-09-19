<?php

namespace App\Exports;

use App\Models\OrderModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrderModel::where('del_status','1')->get();
    }
}
