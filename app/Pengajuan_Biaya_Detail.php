<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Biaya_Detail extends Model
{
    protected $table = 'pengajuan_biaya_detail';
    protected $fillable = ['kode_pengajuan_b','no_description_detail','description','spesifikasi','kode_vendor','no_rekening','bank','pemilik_rekening','qty','harga','jml_harga','potongan','tharga','no_urut','status_detail_atasan','id_user_detail_atasan','tgl_approval_detail_atasan','keterangan_detail_atasan','status_detail','id_user_detail','tgl_approval_detail','keterangan_detail','status_detail_acc','id_user_detail_acc','tgl_approval_detail_acc','keterangan_detail_acc','status_detail_fin','id_user_detail_fin','tgl_approval_detail_fin','keterangan_detail_fin','status_detail_clm','id_user_detail_clm','tgl_approval_detail_clm','keterangan_detail_clm','status_detail_piutang','id_user_detail_piutang','tgl_approval_detail_piutang','keterangan_detail_piutang','status_detail_ng','id_user_detail_ng','tgl_approval_detail_ng','keterangan_detail_ng'];
}
