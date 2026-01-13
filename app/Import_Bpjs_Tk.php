<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Bpjs_Tk extends Model
{
    protected $table = 'import_bpjs_tk';
	protected $fillable = ['no_ref', 'nik_ktp', 'no_pegawai','nama_tk','depo','divisi','departemen','jabatan','tgl_lahir','tgl_kepesertaan','jumlah_upah','jumlah_rapel','iuran_jkk','iuran_jkm','pemberi_kerja_jht_jk','tenaga_kerja_jht_jk','pemberi_kerja_jp','tenaga_kerja_jp','pemberi_kerja_jkp','pemerintah_jkp','total_iuran','iuran_yg_dibayar_perusahaan','iuran_yg_dibayar_tk','uraian','tgl_import','id_user_import'];
}
