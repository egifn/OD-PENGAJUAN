<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangDagang_In_History_Detail extends Model
{
    protected $table = 'barang_dagang_in_detail_history_update';
    protected $fillable = ['doc_id','kode_produk','qty_all','qty_layak','qty_bs','qty_ekspedisi'];
}
