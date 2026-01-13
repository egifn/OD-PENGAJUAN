<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_Pelunasan extends Model
{
    protected $table = 'data_pelunasan';
    protected $fillable = ['tanggal','no_cek','nominal','jatuh_tempo','id_pelanggan','nama_pelanggan','bank','id_user_input','status_cek','status_validasi','id_user_validasi','status_ceklis','no_invoice'];
    protected $guarded = [];
}
