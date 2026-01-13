<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    protected $primaryKey = 'kode_bank';
    protected $keyType = 'integer';
	protected $fillable = ['nama_bank'];
}
