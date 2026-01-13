<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa_3 extends Model
{
    protected $table = 'coa_lv3';
    protected $primaryKey = 'kode_lv3';
    protected $keyType = 'string';
    protected $fillable = ['kode_lv3','account_name','kode_lv1','kode_lv2','id_user'];

    
   public function coa_4()
    {
    	return $this->hasMany(Coa_4::class, 'kode_lv3');
    }
   

}
