<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim_Upload_Surat_Program extends Model
{
    protected $table = 'claim_upload_surat_program';
	protected $fillable = ['no_surat','filename_upload','no_urut_kode','keterangan'];
}
