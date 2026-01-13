<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_F_Detail extends Model
{
    protected $table = 'izin_f_detail';
    protected $fillable = ['kode_izin_f','keterangan','id_cek','kode_seri_warkat','no_cek','seri_awal','seri_akhir','kode_perusahaan','kode_bank',
                            'no_rekening','jml_lembar','no_urut','status'];
}
