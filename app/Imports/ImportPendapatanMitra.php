<?php

namespace App\Imports;

use App\Import_Pendapatan_Mitra;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;



class ImportPendapatanMitra implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Import_Pendapatan_Mitra([
            'nik' => $row[0],
            'id_dms' => $row[1],
            'nama_mitra' => $row[2],
            'depo' => $row[3],
            'divisi' => $row[4],
            'departemen' => $row[5],
            'jabatan' => $row[6],
            'pendapatan' => $row[7],
            'asuransi_tk' => $row[8],
            'asuransi_kes' => $row[9],
            'total_pendapatan' => $row[10],
            'rapel' => $row[11],
            'potongan' => $row[12],
            'grand_total' => $row[13],
            'pembulatan' => $row[14],
            'no_rek' => $row[15],
            'absen' => $row[16],
            'umr' => $row[17],
            'uraian' => $row[18],
            'tgl_import' => Carbon::now()->format('Y-m-d'),
            'id_user_import' => Auth::user()->id
        ]);

    }
}
