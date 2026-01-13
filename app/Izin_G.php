<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_G extends Model
{
    protected $table = 'izin_g';
    protected $primaryKey = 'kode_izin_g';
    protected $keyType = 'string';
    protected $fillable = ['kode_izin_g','tgl_izin_g','tgl_kirim','no_izin_g','judul_izin_g','catatan','yang_ttd','kode_terima','tgl_terima','id_user_penerima','status','no_urut','id_user_input','id_user_pengaju',
                            'status_mengetahui_1','id_user_mengetahui_1','tgl_approval_1','keterangan_mengetahui_1','kode_mengetahui_1',
                            'status_mengetahui_2','id_user_mengetahui_2','tgl_approval_2','keterangan_mengetahui_2','kode_mengetahui_2',
                            'status_approval','id_user_approval','tgl_approval','keterangan_approval','kode_approval'];
}
