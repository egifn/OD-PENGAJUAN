<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MutasiGudang_Detail extends Model
{
    protected $table = 'mutasi_gudang_detail';
    protected $fillable = ['kode_mutasi','kode_produk','qty'];
}
