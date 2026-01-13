<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Mutasi_Bri extends Model
{
    protected $table = 'import_mutasi_bri';
	protected $fillable = ['tanggal','transaksi','debit','kredit','saldo','tgl_import','id_user_import'];
}
