<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area_Sub extends Model
{
    protected $table = 'area_sub';
    protected $primaryKey = 'kode_sub_area';
    protected $keyType = 'string';
    protected $fillable = ['kode_sub_area','kode_area','nama_sub_area','kode_depo'];
}
