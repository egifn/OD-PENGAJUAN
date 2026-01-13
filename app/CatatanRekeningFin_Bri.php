<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanRekeningFin_Bri extends Model
{
    protected $table = 'catatan_rekening_fin_bri';
    protected $fillable = ['tanggal','transaksi','debit','kredit','saldo','status','kode_bank','kode_user'];
    protected $guarded = [];
}
