<?php

namespace App\Imports;

use App\CatatanRekeningFin;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class CatatanRekeningFinImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatatanRekeningFin([
            'tanggal_rek' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'norek' => $row[1],
            'kode' => $row[2],
            'description' => $row[3],
            'nilai' => $row[4],
            'status' => '0',
            'kode_bank' =>request()->kode_bank,
            'kode_user' => Auth::user()->id
        ]);
    }
}
