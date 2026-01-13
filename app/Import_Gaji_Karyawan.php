<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Gaji_Karyawan extends Model
{
    protected $table = 'import_gaji_karyawan';
	protected $fillable = ['depo', 'divisi', 'departemen','jml_karyawan','gaji','uraian','tgl_import','id_user_import'];
}
