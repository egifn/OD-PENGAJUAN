<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanRekeningFin_Maybank extends Model
{
    protected $table = 'catatan_rekening_fin_maybank';
    protected $fillable = ['transaction_date','transaction_time','posting_date','processing_time','transaction_description','transaction_ref','debit','credit','source_code','teller_id','transaction_code','end_balance','status','kode_bank','kode_user'];
    protected $guarded = [];
}
