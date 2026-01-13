<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanBiayaBbmSales extends Model
{
    protected $table = 'pengajuan_biaya_bbm_sales';
    protected $primaryKey = 'kode_pengajuan_bbm';
    protected $keyType = 'string';
    protected $fillable = ['kode_pengajuan_bbm','tgl_pengajuan_bbm','id_pengeluaran','kode_perusahaan','kode_depo','no_faktur','tgl_faktur','nopol','nama_sales',
    'divisi','segmen','km_akhir','kode_bbm','volume_perliter','harga_perliter','total','status','id_user_input','status_atasan','id_user_approval_atasan','tgl_approval_atasan',
    'keterangan_app_atasan','kode_app_atasan','status_biaya_pusat','id_user_approval_biaya_pusat','tgl_approval_biaya_pusat','keterangan_app_biaya_pusat','kode_app_biaya_pusat',
    'status_buat_spp','no_spp','tgl_spp','id_user_approval_spp_1','tgl_approval_spp_1','status_spp_1','id_user_approval_spp_2','tgl_approval_spp_2','status_spp_2','week','no_urut'];
}
