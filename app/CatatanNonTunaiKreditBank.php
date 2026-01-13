<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanNonTunaiKreditBank extends Model
{
    protected $table = 'catatan_non_tunai_kredit_bank';
    protected $fillable = ['kode_doc','tanggal_rek','no_transaksi','deskripsi','nilai','norek','no_transaksi_lawan','tanggal_btu','tanggal_validasi','status','id_user_input'];
    protected $guarded = [];
}
