<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanRekeningFin extends Model
{
    protected $table = 'catatan_rekening_fin';
    protected $fillable = ['tanggal_rek','norek','kode','description','nilai','status','kode_bank','kode_user'];
    protected $guarded = [];
}
