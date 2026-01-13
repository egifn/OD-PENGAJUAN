<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';
    protected $primaryKey = 'kode_pengajuan';
    protected $keyType = 'string';
    protected $fillable = ['kode_pengajuan','tgl_pengajuan','kode_perusahaan','kode_depo','kode_divisi','jenis','keterangan','status_pengajuan','id_user_input','status_atasan','id_user_approval_atasan','tgl_approval_atasan','id_user_approval_it','status_it','tgl_approval_it','id_user_approval_ga','status_ga','tgl_approval_ga','id_user_approval_ops','status_ops','tgl_approval_ops','id_user_approval_pc','status_pc','tgl_approval_pc','id_user_approval_tgsm','tgl_approval_tgsm','status_tgsm','id_user_approval_bod','tgl_approval_bod','status_bod','id_user_update','keterangan_approval','status_validasi_adm_it','status_validasi_adm_ga','status_validasi_adm_ops','status_validasi_adm_pc','status_validasi_adm_tgsm','keterangan_tgsm','status_buat_spp','no_spp','tgl_spp','id_user_approval_spp_1','tgl_approval_spp_1','status_spp_1','id_user_approval_spp_2','tgl_approval_spp_2','status_spp_2','no_urut','sisa_budget'];

    protected $guarded = [];
    protected $appends = ['status_pengajuan'];
    
}
