<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanRekeningFin_Ocbc extends Model
{
    protected $table = 'catatan_rekening_fin_ocbc';
    protected $fillable = ['transaction_date','value_date','references_no','cheque_no','description','debit','kredit','balance','status','kode_bank','kode_user'];
    protected $guarded = [];
}
