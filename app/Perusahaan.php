<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaans';
    protected $primaryKey = 'kode_perusahaan';
    protected $keyType = 'string';
    protected $fillable = ['kode_perusahaan','nama_perusahaan'];
}
