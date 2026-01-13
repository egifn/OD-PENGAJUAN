<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa_1 extends Model
{
    protected $table = 'coa_lv1';
    protected $primaryKey = 'kode_lv1';
    protected $keyType = 'string';
    protected $fillable = ['kode_lv1','account_name','id_user'];
    

    public function coa_2()
    {
    	return $this->hasMany(Coa_2::class, 'kode_lv1');
    }

    public function coa_3()
    {
    	return $this->hasMany(Coa_3::class, 'kode_lv1');
    }

    public function coa_4()
    {
    	return $this->hasMany(Coa_4::class, 'kode_lv1');
    }

   


    
}
