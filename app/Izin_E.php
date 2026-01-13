<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_E extends Model
{
    protected $table = 'izin_e';
    protected $primaryKey = 'kode_izin_e';
    protected $keyType = 'string';
    protected $fillable = ['kode_izin_e','tgl_izin_e','tgl_kirim','no_izin_e','judul_izin_e','catatan','yang_ttd','kode_terima','tgl_terima','id_user_penerima','status','no_urut','id_user_input','id_user_pengaju',
                            'status_mengetahui_1','id_user_mengetahui_1','tgl_approval_1','keterangan_mengetahui_1','kode_mengetahui_1',
                            'status_mengetahui_2','id_user_mengetahui_2','tgl_approval_2','keterangan_mengetahui_2','kode_mengetahui_2',
                            'status_approval','id_user_approval','tgl_approval','keterangan_approval','kode_approval'];
}
