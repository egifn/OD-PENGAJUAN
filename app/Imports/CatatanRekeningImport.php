<?php

namespace App\Imports;

use App\CatatanRekening;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class CatatanRekeningImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatatanRekening([
            'tanggal_rek' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'norek' => $row[1],
            'kode' => $row[2],
            'description' => $row[3],
            'nilai' => $row[4],
            'status' => '0',
            'kode_user' => Auth::user()->id
        ]);
    }
}
