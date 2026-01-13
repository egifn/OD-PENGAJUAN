<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kontrabon_Detail extends Model
{
    protected $table = 'kontrabon_detail';
    protected $fillable = ['kode_kontrabon','no_faktur','tgl_faktur','total_faktur','no_transaksi'];
}
