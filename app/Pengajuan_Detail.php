<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Detail extends Model
{
    protected $table = 'pengajuan_detail';
    protected $fillable = ['kode_pengajuan','id_kategori','kode_product','qty','qty_it','qty_ops','qty_ga','qty_pc','harga_satuan','harga_total','kode_divisi','description','image','status_cek_atasan','id_user_detail_atasan','tgl_approval_detail_atasan','keterangan_detail_atasan','status_cek_it','id_user_adm_it','tgl_approval_adm_it','keterangan_detail_adm_it','status_cek_ga','id_user_adm_ga','tgl_approval_adm_ga','keterangan_detail_adm_ga','status_cek_ops','id_user_adm_ops','tgl_approval_adm_ops','keterangan_detail_adm_ops','status_cek_pc','id_user_adm_pc','tgl_approval_adm_pc','keterangan_detail_adm_pc','status_cek_tgsm','id_user_adm_tgsm','tgl_approval_adm_tgsm','keterangan_detail_adm_tgsm','status_cek_bod','no_urut'];
}
