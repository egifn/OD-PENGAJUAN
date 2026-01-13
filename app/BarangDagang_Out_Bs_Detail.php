<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangDagang_Out_Bs_Detail extends Model
{
    protected $table = 'barang_dagang_out_bs_detail';
    protected $fillable = ['doc_id','kode_produk','qty_all','qty_layak','qty_bs','qty_ekspedisi'];
}
