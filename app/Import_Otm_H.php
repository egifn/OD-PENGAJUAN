<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Otm_H extends Model
{
    protected $table = 'import_otm_h';
    protected $primaryKey = 'kode_otm_h';
    protected $keyType = 'string';
    protected $fillable = ['kode_otm_h','tgl_otm_h','id_user_input'];
}
