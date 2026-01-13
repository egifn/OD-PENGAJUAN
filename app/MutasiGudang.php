<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MutasiGudang extends Model
{
    protected $table = 'mutasi_gudang';
    protected $primaryKey = 'kode_mutasi';
    protected $keyType = 'string';
    protected $fillable = ['kode_mutasi','kode_perusahaan','kode_depo','tanggal','waktu','kode_area_asal','kode_sub_area_asal','kode_area_tujuan','kode_sub_area_tujuan','status','id_user_approved','id_user_input','id_user_input_masuk'];
}
