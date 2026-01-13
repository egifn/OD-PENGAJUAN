<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Mutasi_Ocbc extends Model
{
    protected $table = 'import_mutasi_ocbc';
	protected $fillable = ['tgl_transaksi','value_date','no_reference','no_cek','deskripsi','debit','kredit','balance','tgl_import','id_user_import'];
}
