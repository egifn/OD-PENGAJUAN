<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Mutasi_Bca extends Model
{
    protected $table = 'import_mutasi_bca';
	protected $fillable = ['tgl_transaksi','deskripsi','cabang','debit','kredit','saldo','tgl_import','id_user_import'];
}
