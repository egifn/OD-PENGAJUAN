<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSuratTemplate extends Model
{
    protected $table = 'ms_surat_template';
	protected $fillable = ['kode_perusahaan',
					 		'header_judul',
					 		'header_alamat',
					 		'kepada',
					 		'alamat_tujuan_1',
					 		'alamat_tujuan_2',
					 		'alamat_tujuan_3',
					 		'prihal',
					 		'up',
					 		'isi_1',
					 		'isi_2',
					 		'penutup'
					 	];
}
