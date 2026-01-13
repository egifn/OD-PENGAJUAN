<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Vendor extends Model
{
    protected $table = 'pengajuan_vendor';
	protected $fillable = ['tgl_pengajuan_v','nama_vendor', 'alamat','telepon','kategori_vendor','id_user_input','status','id_user_app','tgl_app'];
}
