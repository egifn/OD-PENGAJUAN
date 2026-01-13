<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim_Surat_Program_Import extends Model
{
    protected $table = 'claim_surat_program_import';
	protected $fillable = ['tgl_import', 'no_surat','id_user_input','no_urut'];
}
