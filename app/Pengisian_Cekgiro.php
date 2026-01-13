<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengisian_Cekgiro extends Model
{
    protected $table = 'pengisian_cekgiro';
    protected $primaryKey = 'kode_pengisian';
    protected $keyType = 'string';
    protected $fillable = ['kode_pengisian','tgl_pengisian','kode_perusahaan','bulan_pengeluaran_awal','bulan_pengeluaran_akhir','kode_sub','id_categories','id_sub_categories','description','no_invoice','no_kontrabon','no_surat_jalan','status','id_user_input'];
}
