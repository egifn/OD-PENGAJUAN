<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    protected $table = 'jurnal_umum';
    protected $primaryKey = 'no';
	protected $fillable = ['tgl','no_coa_transaksi','kode_transaksi','kode_account','debit','kredit'];
}
