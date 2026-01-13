<?php

namespace App\Imports;

use App\CatatanRekeningFin_Bca;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class CatatanRekeningFinImport_bca implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatatanRekeningFin_Bca([
            'tgl' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'keterangan' => $row[1],
            'cabang' => $row[2],
            'debit' => $row[3],
            'kredit' => $row[4],
            'saldo' => $row[5],
            'status' => '0',
            'kode_bank' =>request()->kode_bank,
            'kode_user' => Auth::user()->id
        ]);
    }
}
