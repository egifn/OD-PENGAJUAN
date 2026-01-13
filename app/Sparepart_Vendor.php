<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart_Vendor extends Model
{
    protected $table = 'sparepart_vendor';
    protected $primaryKey = 'kode_vendor';
    protected $keyType = 'string';
    protected $fillable = ['kode_vendor','kelompok','sub_kelompok','id','nama_vendor','status','id_user_input'];
}
