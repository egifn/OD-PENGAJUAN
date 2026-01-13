<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSuratIsi extends Model
{
    protected $table = 'ms_surat_isi';
    protected $primaryKey = 'kode_surat';
    protected $keyType = 'string';
    protected $fillable = ['kode_surat','kode_perusahaan','tanggal','prihal','id_promo','dokumen','jenis','user_input','no_urut','menyetujui_ext','sebagai_ext','menyetujui_ext2','sebagai_ext2'];
}
