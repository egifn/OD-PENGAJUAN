<?php

namespace App\Imports;

use App\Import_Thr;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;



class ImportThr implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Import_Thr([
            'depo' => $row[0],
            'divisi' => $row[1],
            'departemen' => $row[2],
            'jml_karyawan' => $row[3],
            'thr' => $row[4],
            'uraian' => $row[5],
            'tgl_import' => Carbon::now()->format('Y-m-d'),
            'id_user_import' => Auth::user()->id
        ]);

    }
}
