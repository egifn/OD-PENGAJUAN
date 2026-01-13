<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MutasiGudangEks extends Model
{
    protected $table = 'mutasi_gudang_eks';
    protected $primaryKey = 'kode_mutasi_eks';
    protected $keyType = 'string';
    protected $fillable = ['kode_mutasi_eks','doc_id','kode_perusahaan','kode_depo','tanggal','waktu','kategori','no_mobil','kode_driver','nama_driver','kode_area_asal','kode_sub_area_asal','id_checker_asal','kode_perusahaan_tujuan','kode_depo_tujuan','kode_area_tujuan','kode_sub_area_tujuan','id_checker_tujuan','keterangan','status','status_bm','id_user_approved','id_user_input'];
}
