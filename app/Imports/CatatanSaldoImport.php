<?php

namespace App\Imports;

use App\CatatanSaldo;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class CatatanSaldoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatatanSaldo([
            'account_no' => $row[0],
            'transaction_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
            'value_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'reference_no' => $row[3],
            'cheque_no' => $row[4],
            'description' => $row[5],
            'debet' => $row[6],
            'kredit' => $row[7],
            'balance' => $row[8],
            'kode_perusahaan' => request()->modal_perusahaan,
            'kode_depo' => request()->modal_depo,
            'upload_date' => Carbon::now()->format('Y-m-d'),
            'kode_user' => Auth::user()->id
        ]);
    }
}
