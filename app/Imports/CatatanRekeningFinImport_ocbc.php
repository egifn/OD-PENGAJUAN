<?php

namespace App\Imports;

use App\CatatanRekeningFin_Ocbc;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class CatatanRekeningFinImport_ocbc implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatatanRekeningFin_Ocbc([
            'transaction_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'value_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
            'references_no' => $row[2],
            'cheque_no' => $row[3],
            'description' => $row[4],
            'debit' => $row[5],
            'kredit' => $row[6],
            'balance' => $row[7],
            'status' => '0',
            'kode_bank' =>request()->kode_bank,
            'kode_user' => Auth::user()->id
        ]);
    }
}
