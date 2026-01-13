<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rcm_Spp_Detail_Temp extends Model
{
    protected $table = 'rcm_spp_detail_temp';
    protected $fillable = ['company_code','area_code','code','sparepart_in','no_bon','value'];
}
