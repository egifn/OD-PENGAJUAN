<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Thr extends Model
{
    protected $table = 'import_thr';
	protected $fillable = ['depo','divisi','departemen','jml_karyawan','thr','uraian','tgl_import','id_user_import'];
}
