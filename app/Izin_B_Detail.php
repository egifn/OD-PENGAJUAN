<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_B_Detail extends Model
{
    protected $table = 'izin_b_detail';
    protected $fillable = ['kode_izin_b','keterangan','id_cek','kode_seri_warkat','no_cek','seri_awal','seri_akhir','kode_perusahaan','kode_bank',
                            'no_rekening','kode_vendor','atas_nama','kode_bank_vendor','no_rekening_vendor','jml_lembar','no_urut','status'];
}
