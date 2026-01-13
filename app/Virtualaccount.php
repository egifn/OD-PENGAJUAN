<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Virtualaccount extends Model
{
    protected $table = 'virtualaccounts';
    protected $primaryKey = 'virtualaccount';
    protected $keyType = 'string';
    protected $fillable = ['virtualaccount','kode_perusahaan','kode_depo','jenis','norek','kode_user'];
}
