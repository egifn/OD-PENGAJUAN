<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_H_Detail extends Model
{
    protected $table = 'izin_h_detail';
    protected $fillable = ['kode_izin','kode_perusahaan','kode_bank','no_rekening','id_cek','no_cek','kode_seri_warkat','seri_awal','seri_akhir','jenis_warkat','jml_lembar','no_urut','status'];
}
