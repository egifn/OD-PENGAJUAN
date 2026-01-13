<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Pabrik extends Model
{
    protected $table = 'pengajuan_pabrik';
    protected $primaryKey = 'kode_pesan';
    protected $keyType = 'string';
    protected $fillable = ['kode_pesan','tgl_pesan','kode_pabrik','kode_perusahaan','kode_depo','keterangan','status','id_user_input'];
}
