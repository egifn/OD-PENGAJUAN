<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin_H extends Model
{
    protected $table = 'izin_h';
    protected $primaryKey = 'kode_izin';
    protected $keyType = 'string';
    protected $fillable = ['kode_izin','tgl_izin','no_izin','judul_izin','catatan','no_urut','id_user_input','status_approval','id_user_approval','tgl_approval','keterangan_approval','kode_approval','status_approval_bod','id_user_approval_bod','tgl_approval_bod','keterangan_approval_bod','kode_approval_bod'];
}
