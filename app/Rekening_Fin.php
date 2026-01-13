<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekening_Fin extends Model
{
    protected $table = 'rekening_fin';
    protected $fillable = ['norek','kode_bank','kode_vendor','atas_nama','keterangan','id_user_input','id_user_update'];
}
