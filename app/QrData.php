<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrData extends Model
{
    protected $table = 'qr_data';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id','kode_perusahaan','kode_depo','kode_spv','nama','telepon','alamat','koordinat_lintang','koordinat_bujur','biaya_sewa','jenis','status'];
}
