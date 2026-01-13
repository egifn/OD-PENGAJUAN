<?php

namespace App\Imports;

use App\Rekening_Fin;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;



class VendorAccountImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rekening_Fin([
            'norek' => $row[0],
            'kode_bank' => $row[1],
            'kode_vendor' => $row[2],
            'atas_nama' => $row[3],
            'keterangan' => $row[4],
            'id_user_input' => Auth::user()->id
        ]);
    }
}
