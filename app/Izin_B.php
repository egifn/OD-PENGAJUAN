<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_B extends Model
{
    protected $table = 'izin_b';
    protected $primaryKey = 'kode_izin_b';
    protected $keyType = 'string';
    protected $fillable = ['kode_izin_b','tgl_izin_b','no_izin_b','judul_izin_b','rekening_pembayar','catatan_b','no_urut','id_user_input',
                            'status_mengetahui_1','id_user_mengetahui_1','tgl_approval_1','keterangan_mengetahui_1','kode_mengetahui_1',
                            'status_mengetahui_2','id_user_mengetahui_2','tgl_approval_2','keterangan_mengetahui_2','kode_mengetahui_2',
                            'status_approval','id_user_approval','tgl_approval','keterangan_approval','kode_approval'];
}
