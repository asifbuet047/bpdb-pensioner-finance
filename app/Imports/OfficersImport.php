<?php

namespace App\Imports;

use App\Models\Officer;
use Maatwebsite\Excel\Concerns\ToModel;

class OfficersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Officer([
            //
        ]);
    }
}
