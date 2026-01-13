<?php

namespace App\Imports;

use App\Rcm_Spp_Detail_Temp;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class SppDetailImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rcm_Spp_Detail_Temp([
            'company_code' => $row[0],
            'area_code' => $row[1],
            'code' => $row[2],
            'sparepart_in' => $row[3],
            'no_bon' => $row[4],
            'value' => $row[5]
        ]);
    }
}
