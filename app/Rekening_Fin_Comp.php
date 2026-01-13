<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekening_Fin_Comp extends Model
{
    protected $table = 'rekening_fin_comp';
    protected $primaryKey = 'norek';
    protected $keyType = 'string';
    protected $fillable = ['norek','kode_bank','kode_perusahaan','kode_depo','keterangan','kode_user'];
}
