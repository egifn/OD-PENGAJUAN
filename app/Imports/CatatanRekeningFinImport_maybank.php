<?php

namespace App\Imports;

use App\CatatanRekeningFin_Maybank;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class CatatanRekeningFinImport_maybank implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatatanRekeningFin_Maybank([
            'transaction_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'transaction_time' => $row[1],
            'posting_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'processing_time' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'transaction_description' => $row[4],
            'transaction_ref' => $row[5],
            'debit' => $row[6],
            'credit' => $row[7],
            'source_code' => $row[8],
            'teller_id' => $row[9],
            'transaction_code' => $row[10],
            'end_balance' => $row[11],
            'status' => '0',
            'kode_bank' =>request()->kode_bank,
            'kode_user' => Auth::user()->id
        ]);
    }
}
