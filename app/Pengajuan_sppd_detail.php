<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_sppd_detail extends Model
{
    protected $table = 'pengajuan_sppd_detail';
    protected $fillable = ['kode_pengajuan_sppd','tujuan_perusahaan','tujuan_depo','tgl_mulai','tgl_akhir','jml_hari','keperluan'];
}
