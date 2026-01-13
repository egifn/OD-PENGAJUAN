<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanRekeningFin_Bca extends Model
{
    protected $table = 'catatan_rekening_fin_bca';
    protected $fillable = ['tgl','keterangan','cabang','debit','kredit','saldo','status','kode_bank','kode_user'];
    protected $guarded = [];
}
