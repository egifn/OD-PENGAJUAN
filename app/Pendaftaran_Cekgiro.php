<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran_Cekgiro extends Model
{
    protected $table = 'pendaftaran_cekgiro';
    protected $primaryKey = 'kode_daftar';
    protected $keyType = 'string';
    protected $fillable = ['kode_daftar','tgl_daftar','kode_perusahaan','no_rek_comp','kode_bank','kode_kategori','kode_seri_buku','seri_awal','seri_akhir','keterangan','status','jenis','no_urut','id_user_input'];
}
