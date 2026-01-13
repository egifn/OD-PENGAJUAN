<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kontrabon extends Model
{
    protected $table = 'kontrabon';
    protected $primaryKey = 'no_kontrabon';
    protected $keyType = 'string';
    protected $fillable = ['no_kontrabon','tgl_kontrabon','kode_vendor','total','termin','jatuh_tempo','keterangan','status','type','id_user_input','status_buat_spp','no_spp','tgl_spp','id_user_approval_spp_1','tgl_approval_spp_1','status_spp_1','id_user_approval_spp_2','tgl_approval_spp_2','status_spp_2','id_cek','tgl_pengambilan_cek','no_urut'];
}
