<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa_Transaksi extends Model
{
    protected $table = 'coa_transaksi';
    protected $primaryKey = 'no';
    protected $keyType = 'bigint';
    protected $fillable = ['no','nama_transaksi','id_user_input'];
}
