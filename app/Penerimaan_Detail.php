<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penerimaan_Detail extends Model
{
    protected $table = 'penerimaan_detail';
    protected $fillable = ['no_btb','kode_product','harga_satuan','qty_terima','harga_total'];
}
