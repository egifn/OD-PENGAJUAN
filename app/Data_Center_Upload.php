<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_Center_Upload extends Model
{
    protected $table = 'data_center_upload';
	protected $fillable = ['tgl_upload','filename_upload','keterangan','id_user_input'];
}
