<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisi_Sub extends Model
{
    protected $table = 'divisi_sub';
    protected $fillable = ['nama_divisi_sub','kode_divisi','id_user_input','id_user_update'];
}
