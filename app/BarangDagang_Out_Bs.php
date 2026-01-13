<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangDagang_Out_Bs extends Model
{
    protected $table = 'barang_dagang_out_bs';
    protected $primaryKey = 'doc_id';
    protected $keyType = 'string';
    protected $fillable = ['doc_id','tanggal','waktu','kode_perusahaan','kode_depo','kategori','no_mobil','kode_driver','nama_driver','kode_zona','kode_zona_sub','kode_zona_bs','kode_zona_sub_bs','id_checker','id_checker_bs','id_user_input','status','status_bs','kode_produksi','from'];
}
