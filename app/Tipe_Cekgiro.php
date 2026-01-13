<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipe_Cekgiro extends Model
{
    protected $table = 'tipe_cekgiro';
    protected $primaryKey = 'kode_tipe';
    protected $keyType = 'string';
    protected $fillable = ['kode_tipe','tipe','id_user_input'];
}
