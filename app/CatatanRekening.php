<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanRekening extends Model
{
    protected $table = 'catatan_rekenings';
    protected $fillable = ['tanggal_rek','norek','kode','description','nilai','status','kode_user'];
    protected $guarded = [];
}
