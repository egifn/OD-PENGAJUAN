<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daftar_Selisih extends Model
{
    protected $table = 'daftar_selisih';
	protected $fillable = ['kode_selisih', 'nama_selisih', 'keterangan','id_user_input'];
}
