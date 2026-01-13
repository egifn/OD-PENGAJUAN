<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Claim_Tiv extends Model
{
    protected $table = 'import_claim_tiv';
	protected $fillable = ['area', 'nama_toko', 'cluster','no_rekening','bank','pemilik_rekening','qty','reward_tiv','total_reward','potongan','ditransfer','id_user_input','status'];
}
