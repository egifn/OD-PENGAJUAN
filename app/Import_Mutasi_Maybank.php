<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Mutasi_Maybank extends Model
{
    protected $table = 'import_mutasi_maybank';
	protected $fillable = ['tgl_transaksi','waktu_transaksi','tgl_posting','waktu_proses','deskripsi','ref','debit','kredit','source_code','id_teller','kode_transaksi','end_balance','tgl_import','id_user_import'];
}
