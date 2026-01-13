<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportPencapaianProgramDetailUpdate extends Model
{
    protected $table = 'import_pencapaian_program_detail_update';
	protected $fillable = [
        'kode_update',
        'no_surat',
        'no_surat_tiv',
        'kode_perusahaan',
        'kode_depo',
        'nama_depo',
        'kode_segmen',
        'nama_segmen',
        'cluster',
        'kode_outlet',
        'nama_outlet',
        'qty',
        'reward',
        'reward_tiv',
        'total_reward',
        'no_urut',
        'id_user_input'
    ];
}
