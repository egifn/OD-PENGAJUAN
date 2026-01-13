<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depo_Korsis extends Model
{
    protected $table = 'depos_korsis';
    protected $primaryKey = 'kode_depo';
    protected $keyType = 'string';
    protected $fillable = ['kode_depo','nama_depo','alias','kode_perusahaan'];
}
