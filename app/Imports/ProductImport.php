<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Session;
use Auth;



class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'kode' => $row[0],
            'nama_barang' => $row[1],
            'category_id' => $row[2],
            'merk' => $row[3],
            'satuan' => $row[4],
            'ket' => $row[5],
            'price' => $row[6],
            'stock' => 0,
            'kode_user_input' => Auth::user()->id
        ]);
    }
}
