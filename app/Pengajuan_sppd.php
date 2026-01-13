<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_sppd extends Model
{
    protected $table = 'pengajuan_sppd';
    protected $primaryKey = 'kode_pengajuan_sppd';
    protected $keyType = 'string';
    protected $fillable = ['kode_pengajuan_sppd','id_pengeluaran','tgl_pengajuan_sppd','pelaksana','kode_perusahaan','kode_depo','kode_divisi','tujuan_perusahaan','tujuan_depo','tgl_mulai','tgl_akhir','jml_hari','keperluan','kendaraan','sebagai','id_user_input','status_atasan','id_user_approval_atasan','tgl_approval_atasan','status_validasi_adm_biaya','id_user_validasi_adm_biaya','tgl_validasi_adm_biaya','status_biaya','id_user_approval_biaya','tgl_approval_biaya','status_hrd','id_user_approval_hrd','tgl_approval_hrd','keterangan_approval'];
}
