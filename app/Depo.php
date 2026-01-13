<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depo extends Model
{
    protected $table = 'depos';
    protected $primaryKey = 'kode_depo';
    protected $keyType = 'string';
    protected $fillable = ['kode_depo','nama_depo','alias','kode_perusahaan'];

    

}
