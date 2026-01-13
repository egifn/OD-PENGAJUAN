<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spp_Sumberdana extends Model
{
    protected $table = 'spp_sumber_dana';
	protected $fillable = ['sumber_dana', 'keterangan'];
}
