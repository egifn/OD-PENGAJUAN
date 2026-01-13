<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPengeluaran extends Model
{
    protected $table = 'ms_pengeluaran';
    protected $primaryKey = 'id';
    protected $keyType = 'bigInt';
    protected $fillable = [
    	'nama_pengeluaran',
    	'sifat',
    	'jenis',
    	'pembayaran',
		'cara_pembayaran',
        'kontrabon',
        'keterangan',
    	'kategori',
    	'coa',
    	'id_user_input',
    ];
}
