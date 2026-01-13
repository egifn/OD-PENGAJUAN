<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_Pengajuan_Cek_Giro_d extends Model
{
    protected $table = 'izin_pengajuan_cek_giro_d';
    protected $fillable = ['kode_pengajuan_cek','kode_perusahaan','kode_bank','no_rekening','banyak_buku','sisa_banyak_buku','jml_lembar','sisa_jml_lembar','jenis_buku','status'];
}
