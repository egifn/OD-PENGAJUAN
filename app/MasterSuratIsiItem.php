<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSuratIsiItem extends Model
{
    protected $table = 'ms_surat_isi_item';
    protected $fillable = ['kode_surat','kode_depo','amount','amount_2','kode_produk'];
}
