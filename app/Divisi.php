<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisi';
	protected $fillable = ['nama_divisi','kepala_divisi', 'id_user_input','id_user_update'];
}
