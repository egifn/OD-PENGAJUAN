<?php

namespace App\Imports;

use App\Import_Insentif;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;



class ImportInsentif implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Import_Insentif([
            'nik' => $row[0],
            'status' => $row[1],
            'nama_karyawan' => $row[2],
            'depo' => $row[3],
            'divisi' => $row[4],
            'departemen' => $row[5],
            'jabatan' => $row[6],
            'insentif' => $row[7],
            'insentif_program_lain' => $row[8],
            'total' => $row[9],
            'pembulatan' => $row[10],
            'no_rek' => $row[11],
            'uraian' => $row[12],
            'tgl_import' => Carbon::now()->format('Y-m-d'),
            'id_user_import' => Auth::user()->id
        ]);

    }
}
