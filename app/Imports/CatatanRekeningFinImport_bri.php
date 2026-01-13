<?php

namespace App\Imports;

use App\CatatanRekeningFin_Bri;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class CatatanRekeningFinImport_bri implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatatanRekeningFin_Bri([
            'tanggal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'transaksi' => $row[1],
            'debit' => $row[2],
            'kredit' => $row[3],
            'saldo' => $row[4],
            'status' => '0',
            'kode_bank' =>request()->kode_bank,
            'kode_user' => Auth::user()->id
        ]);
    }
}
