<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_E_Detail extends Model
{
    protected $table = 'izin_e_detail';
    protected $fillable = ['kode_izin_e','id_cek','kode_seri_warkat','no_cek','seri_awal','seri_akhir','kode_perusahaan','kode_bank',
                            'no_rekening','no_urut','status'];
}
