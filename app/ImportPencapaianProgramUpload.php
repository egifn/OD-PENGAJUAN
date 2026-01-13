<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportPencapaianProgramUpload extends Model
{
    protected $table = 'import_pencapaian_program_upload';
	protected $fillable = ['no_urut','id_program','filename'];
}
