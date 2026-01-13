<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Temp extends Model
{
    protected $table = 'pengajuan_temp';
    protected $primaryKey = 'kode_produk';
    protected $keyType = 'string';
    protected $fillable = ['kode_produk','qty'];
}
