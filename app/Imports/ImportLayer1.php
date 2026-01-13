<?php

namespace App\Imports;

use App\Coa_1;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class ImportLayer1 implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Coa_1([
            'kode_lv1' => $row[0],
            'account_name' => $row[1],
            'id_user' => Auth::user()->id
        ]);
    }
}
