<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Bpjs_Kes extends Model
{
    protected $table = 'import_bpjs_kes';
	protected $fillable = ['no_jkn_pekerja', 'no_jkn_peserta', 'npp','nama_karyawan','depo','divisi','departemen','jabatan','hubungan_keluarga','premi','upah','iuran_yg_dibayar_perusahaan','iuran_yg_dibayar_karyawan','uraian','tgl_import','id_user_import'];
}
