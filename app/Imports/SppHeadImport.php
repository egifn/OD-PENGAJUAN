<?php

namespace App\Imports;

use App\Rcm_Spp_Temp;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class SppHeadImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rcm_Spp_Temp([
            'user_created' => $row[0],
            'user_updated' => $row[1],
            'date_created' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'date_updated' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'company_1' => $row[4],
            'area_code' => $row[5],
            'code' => $row[6],
            'operator' => $row[7],
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]),
            'sender' => $row[9],
            'supplier_code' => $row[10],
            'supplier_name' => $row[11],
            'no_kontrabon' => $row[12],
            'total_value_kontrabon' => $row[13],
            'date_payment' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
            'company_2' => $row[15],
            'kode_kepala_biaya' => $row[16],
            'nama_kepala_biaya' => $row[17],
            'kode_biaya' => $row[18],
            'nama_biaya' => $row[19],
            'type' => request()->type,
            'status' => '0'
        ]);
    }
}
