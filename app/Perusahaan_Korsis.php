<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perusahaan_Korsis extends Model
{
    protected $table = 'perusahaans_korsis';
    protected $primaryKey = 'kode_perusahaan';
    protected $keyType = 'string';
    protected $fillable = ['kode_perusahaan','nama_perusahaan'];
}
