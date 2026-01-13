<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouse';
	protected $fillable = ['kode_perusahaan', 'kode_depo', 'kode_produk','kode_area','kode_sub_area','qty'];
}
