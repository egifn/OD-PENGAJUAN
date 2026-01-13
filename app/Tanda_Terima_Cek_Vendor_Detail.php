<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanda_Terima_Cek_Vendor_Detail extends Model
{
    protected $table = 'tanda_terima_cek_detail';
    protected $fillable = ['receipt_id','jenis_pengeluaran','total','cek_giro','tanggal','kd_perusahaan','bank','norek_perusahaan','vendor','atas_nama','bank_vendor','norek_vendor','status'];
}
