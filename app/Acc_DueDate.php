<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acc_DueDate extends Model
{
    protected $table = 'acc_jatuh_tempo';
    protected $primaryKey = 'id';
    protected $keyType = 'bigInt';
	protected $fillable = ['doc_id','customer_id','customer_name','amount','remain','doc_date','due_date','due_date_updated','kode_perusahaan','id_user','time_update'];
}
