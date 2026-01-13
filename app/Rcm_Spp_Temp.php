<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rcm_Spp_Temp extends Model
{
    protected $table = 'rcm_spp_temp';
    protected $fillable = ['user_created','user_updated','date_created','date_updated','company_1','area_code','code','operator','date','sender','supplier_code','supplier_name','no_kontrabon','total_value_kontrabon','date_payment','company_2','kode_kepala_biaya','nama_kepala_biaya','kode_biaya','nama_biaya','type','status'];
}
