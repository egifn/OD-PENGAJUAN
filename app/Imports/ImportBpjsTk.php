<?php

namespace App\Imports;

use App\Import_Bpjs_Tk;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;



class ImportBpjsTk implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Import_Bpjs_Tk([
            'no_ref' => $row[0],
            'nik_ktp' => $row[1],
            'no_pegawai' => $row[2],
            'nama_tk' => $row[3],
            'depo' => $row[4],
            'divisi' => $row[5],
            'departemen' => $row[6],
            'jabatan' => $row[7],
            'tgl_lahir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]),
            'tgl_kepesertaan' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[9]),
            'jumlah_upah' => $row[10],
            'jumlah_rapel' => $row[11],
            'iuran_jkk' => $row[12],
            'iuran_jkm' => $row[13],
            'pemberi_kerja_jht_jk' => $row[14],
            'tenaga_kerja_jht_jk' => $row[15],
            'pemberi_kerja_jp' => $row[16],
            'tenaga_kerja_jp' => $row[17],
            'pemberi_kerja_jkp' => $row[18],
            'pemerintah_jkp' => $row[19],
            'total_iuran' => $row[20],
            'iuran_yg_dibayar_perusahaan' => $row[21],
            'iuran_yg_dibayar_tk' => $row[22],
            'uraian' => $row[23],
            'tgl_import' => Carbon::now()->format('Y-m-d'),
            'id_user_import' => Auth::user()->id
        ]);

    }
}
