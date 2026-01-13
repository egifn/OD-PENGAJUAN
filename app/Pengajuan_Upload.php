<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_Upload extends Model
{
    protected $table = 'pengajuan_upload';
	protected $fillable = ['kode_pengajuan','no_description_detail','description','filename'];
}
