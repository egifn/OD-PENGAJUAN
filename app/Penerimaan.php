<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    protected $table = 'penerimaan';
    protected $primaryKey = 'no_btb';
    protected $keyType = 'string';
    protected $fillable = ['no_btb','tgl_terima','kode_vendor','kode_pembelian','no_faktur','tgl_faktur','status','id_user_input'];
}
