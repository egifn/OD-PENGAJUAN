<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Pendapatan_Mitra extends Model
{
    protected $table = 'import_pendapatan_mitra';
	protected $fillable = ['nik', 'id_dms', 'nama_mitra','depo','divisi','departemen','jabatan','pendapatan','asuransi_tk','asuransi_kes','total_pendapatan','rapel','potongan','grand_total','pembulatan','no_rek','absen','umr','uraian','tgl_import','id_user_import'];
}
