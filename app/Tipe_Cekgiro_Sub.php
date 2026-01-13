<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipe_Cekgiro_Sub extends Model
{
    protected $table = 'tipe_cekgiro_sub';
    protected $primaryKey = 'kode_sub';
    protected $keyType = 'string';
    protected $fillable = ['kode_sub','kode_tipe','sub_tipe','id_user_input'];
}
