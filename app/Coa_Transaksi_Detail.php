<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa_Transaksi_Detail extends Model
{
    protected $table = 'coa_transaksi_detail';
    protected $fillable = ['no','id_debit','id_kredit'];
}
