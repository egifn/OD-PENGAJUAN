<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checker extends Model
{
    protected $table = 'checker';
    protected $primaryKey = 'id_checker';
    protected $keyType = 'bigint';
	protected $fillable = ['id_checker','nama_checker', 'kode_perusahaan', 'kode_depo','kategori'];
}
