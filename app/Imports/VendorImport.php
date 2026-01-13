<?php

namespace App\Imports;

use App\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;



class VendorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Vendor([
            'kode_vendor' => $row[0],
            'nama_vendor' => $row[1],
            'alamat' => $row[2],
            'telp' => $row[3],
            'fax' => $row[4],
            'email' => $row[5],
            'contact_person' => $row[6],
            'jabatan' => $row[7],
            'top' => $row[8],
            'tgl_mulai' => $row[9],
            'tgl_selesai' =>$row[10],
            'status_1' => $row[11],
            'status_2' => $row[12],
            'tgl_memo' => $row[13],
            'memo' => $row[14],
            'approved_by' => $row[15],
            'tgl_approved' => $row[16],
            'keterangan' => $row[17],
            'id_user_input' => Auth::user()->id
        ]);
    }
}
