<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian_Detail extends Model
{
    protected $table = 'pembelian_detail';
    protected $fillable = ['kode_pembelian','kode_product','harga_satuan','qty','qty_po','satuan','harga_total','no_urut_po'];
}
