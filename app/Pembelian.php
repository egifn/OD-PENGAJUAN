<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'kode_pembelian';
    protected $keyType = 'string';
    protected $fillable = ['kode_pembelian','tgl_pembelian','kode_perusahaan','periode','kode_vendor','kode_pengajuan','ket_transaksi','status','id_user_input','no_urut_po'];
    
}
