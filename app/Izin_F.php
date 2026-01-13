<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_F extends Model
{
    protected $table = 'izin_f';
    protected $primaryKey = 'kode_izin_f';
    protected $keyType = 'string';
    protected $fillable = ['kode_izin_f','tgl_izin_f','no_izin_f','judul_izin_f','catatan_f','no_urut','id_user_input','id_user_pengaju',
                            'status_mengetahui_1','id_user_mengetahui_1','tgl_approval_1','keterangan_mengetahui_1','kode_mengetahui_1',
                            'status_mengetahui_2','id_user_mengetahui_2','tgl_approval_2','keterangan_mengetahui_2','kode_mengetahui_2',
                            'status_approval','id_user_approval','tgl_approval','keterangan_approval','kode_approval'];
}
