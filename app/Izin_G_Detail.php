<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_G_Detail extends Model
{
    protected $table = 'izin_g_detail';
    protected $fillable = ['kode_izin_g','keterangan','id_cek','kode_seri_warkat','no_cek','seri_awal','seri_akhir','kode_perusahaan','kode_bank',
                            'no_rekening','no_urut','status'];
}
