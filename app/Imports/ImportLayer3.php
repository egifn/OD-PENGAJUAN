<?php

namespace App\Imports;

use App\Coa_3;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class ImportLayer3 implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Coa_3([
            'kode_lv3' => $row[0],
            'account_name' => $row[1],
            'kode_lv1' => $row[2],
            'kode_lv2' => $row[3],
            'id_user' => Auth::user()->id
        ]);
    }
}
