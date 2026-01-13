<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim_Surat_Program_Detail extends Model
{
    protected $table = 'claim_surat_program_detail';
    protected $fillable = ['no_surat','kode_perusahaan','kode_depo','status_terima_asm','status_terima_kpj','no_urut'];
}
