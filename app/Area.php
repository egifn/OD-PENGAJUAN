<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'kode_area';
    protected $keyType = 'string';
    protected $fillable = ['kode_area','nama_area','kode_depo'];
}
