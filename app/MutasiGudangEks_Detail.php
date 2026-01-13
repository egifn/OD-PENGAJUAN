<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MutasiGudangEks_Detail extends Model
{
    protected $table = 'mutasi_gudang_eks_detail';
    protected $fillable = ['kode_mutasi_eks','kode_produk','qty'];
}
