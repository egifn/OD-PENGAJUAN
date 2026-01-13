<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim_Upload_Surat_Program_Depo extends Model
{
    protected $table = 'claim_upload_surat_program_depo';
	protected $fillable = ['no_surat','kode_perusahaan','filename_upload_depo','no_urut_kode_depo'];
}
