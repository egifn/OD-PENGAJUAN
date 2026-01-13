<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Insentif extends Model
{
    protected $table = 'import_insentif';
	protected $fillable = ['nik', 'status', 'nama_karyawan','depo','divisi','departemen','jabatan','insentif','insentif_program_lain','total','pembulatan','no_rek','uraian','tgl_import','id_user_import'];
}
