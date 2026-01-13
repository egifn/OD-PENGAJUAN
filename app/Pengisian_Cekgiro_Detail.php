<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengisian_Cekgiro_Detail extends Model
{
    protected $table = 'pengisian_cekgiro_detail';
    protected $fillable = ['kode_pengisian','no_spp','id_cek','total_spp','total_cek','tgl_cek','status'];
}
