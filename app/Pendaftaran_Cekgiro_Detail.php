<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran_Cekgiro_Detail extends Model
{
    protected $table = 'pendaftaran_cekgiro_detail';
    protected $fillable = ['kode_daftar','id_cek','no_cek','no_urut','status_detail'];
}
