<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanNonTunaiKreditPerusahaan extends Model
{
    protected $table = 'catatan_non_tunai_kredit_perusahaan';
    protected $fillable = ['kode_doc','tanggal_btu','kno_transaksiode','kode_perusahaan','kode_depo','kode_toko','id_cek','nilai','jatuh_tempo','norek','no_transaksi_lawan','tanggal_validasi','status','id_user_input'];
    protected $guarded = [];
}
