<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanda_Terima_Cek_Vendor extends Model
{
    protected $table = 'tanda_terima_cek';
    protected $primaryKey = 'receipt_id';
    protected $keyType = 'string';
    protected $fillable = ['receipt_id','date_receipt','penerima','keterangan','keterangan_id','status','id_user_input','date_send','keterangan_approval'];
}
