<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekenings';
    protected $primaryKey = 'norek';
    protected $keyType = 'string';
    protected $fillable = ['norek','kode_bank','kode_perusahaan','kode_depo','kode_user'];
}
