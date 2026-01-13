<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Pabrik_Detail extends Model
{
    protected $table = 'pengajuan_pabrik_detail';
    protected $fillable = ['kode_pesan','kode_produk','nama_produk','unit','qty','harga_satuan','harga_total'];
}
