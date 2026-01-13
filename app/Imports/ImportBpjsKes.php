<?php

namespace App\Imports;

use App\Import_Bpjs_Kes;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;



class ImportBpjsKes implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Import_Bpjs_Kes([
            'no_jkn_pekerja' => $row[0],
            'no_jkn_peserta' => $row[1],
            'npp' => $row[2],
            'nama_karyawan' => $row[3],
            'depo' => $row[4],
            'divisi' => $row[5],
            'departemen' => $row[6],
            'jabatan' => $row[7],
            'hubungan_keluarga' => $row[8],
            'premi' => $row[9],
            'upah' => $row[10],
            'iuran_yg_dibayar_perusahaan' => $row[11],
            'iuran_yg_dibayar_karyawan' => $row[12],
            'uraian' => $row[13],
            'tgl_import' => Carbon::now()->format('Y-m-d'),
            'id_user_import' => Auth::user()->id
        ]);

    }
}
