<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa_4 extends Model
{
    protected $table = 'coa_lv4';
    protected $primaryKey = 'kode_lv4';
    protected $keyType = 'string';
    protected $fillable = ['kode_lv4','account_name','kode_lv1','kode_lv2','kode_lv3','id_user'];
}
