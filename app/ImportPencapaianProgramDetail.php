<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportPencapaianProgramDetail extends Model
{
    protected $table = 'import_pencapaian_program_detail';
	protected $fillable = [
        'tgl_import',
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
        'status',
        'no_urut',
        'id_user_input'
    ];
}
