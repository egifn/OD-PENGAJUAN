<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrData_Head extends Model
{
  	protected $table = 'qr_data_head';
  	protected $primaryKey = 'kode';
    protected $keyType = 'string';
	protected $fillable = ['kode','kode_perusahaan','tanggal'];
}
