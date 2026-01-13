<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan_upload_Bbm extends Model
{
    protected $table = 'pengajuan_upload_bbm';
	protected $fillable = ['kode_pengajuan_bbm','no_description','description','filename'];
}
