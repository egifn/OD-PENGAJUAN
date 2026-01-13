<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa_2 extends Model
{
    protected $table = 'coa_lv2';
    protected $primaryKey = 'kode_lv2';
    protected $keyType = 'string';
    protected $fillable = ['kode_lv2','account_name','kode_lv1','id_user'];


    public function coa_1()
    {
    	return $this->belongsTo(Coa_1::class, 'kode_lv1');
    }

    public function coa_3()
    {
    	return $this->hasMany(Coa_3::class, 'kode_lv2');
    }

    
}
