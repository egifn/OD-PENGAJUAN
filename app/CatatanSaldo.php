<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanSaldo extends Model
{
    protected $table = 'catatan_saldo';
    protected $fillable = ['account_no','transaction_date','value_date','reference_no','cheque_no','description','debet','kredit','balance','kode_perusahaan','kode_depo','upload_date','kode_user','status'];
    protected $guarded = [];
}
