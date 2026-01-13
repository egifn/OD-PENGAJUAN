<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Biaya extends Model
{
    protected $table = 'pengajuan_biaya';
    protected $primaryKey = 'kode_pengajuan_b';
    protected $keyType = 'string';
    protected $fillable = ['kode_pengajuan_b','tgl_pengajuan_b','kategori','tipe','kode_perusahaan','kode_depo','kode_divisi','kode_perusahaan_tujuan',
    'no_surat_program','id_program','status','keterangan','id_user_input','status_ssd','id_approval_ssd','tgl_approval_ssd','keterangan_app_ssd','kode_app_ssd',
    'status_atasan','id_user_approval_atasan','tgl_approval_atasan','keterangan_app_atasan','kode_app_atasan',
    'status_som','id_approval_som','tgl_approval_som','keterangan_app_som','kode_app_som','status_biaya_pusat','id_user_approval_biaya_pusat','tgl_approval_biaya_pusat',
    'kode_app_biaya_pusat','status_biaya','id_user_approval_biaya','tgl_approval_biaya','kode_app_biaya',
    'status_ka_akunting','id_approval_ka_akunting','tgl_approval_ka_akunting','kode_app_kakunting','status_fin','id_approval_fin','tgl_approval_fin','kode_app_finance',
    'status_claim','id_approval_claim','tgl_approval_claim','kode_app_claim',
    'status_piutang','id_approval_piutang','tgl_approval_piutang','kode_app_piutang','keterangan_app_piutang',
    'status_ng','id_approval_ng','tgl_approval_ng','keterangan_app_ng','kode_app_ng',
    'status_bod_otorisasi','id_user_bod_otorisasi','tgl_bod_otorisasi','status_bod','id_approval_bod','tgl_approval_bod','kode_app_bod',
    'id_user_payment','tgl_payment','status_buat_spp','no_spp','tgl_spp','id_user_approval_spp_1','tgl_approval_spp_1','status_spp_1',
    'id_user_approval_spp_2','tgl_approval_spp_2','status_spp_2','no_urut','keterangan_approval',
    'status_validasi','status_validasi_acc','status_validasi_ka_akunting','status_validasi_fin','status_validasi_fin_upload','status_validasi_clm','status_validasi_piutang','status_validasi_ng'];
}
