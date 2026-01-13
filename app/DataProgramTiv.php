<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataProgramTiv extends Model
{
    protected $table = 'import_data_program_tiv';
    protected $fillable = ['tgl_import','id_program','region','dist_perusahaan','dist_depo','customer_id','cuastomer_name','sub_segmen','cluster','target_m_1',
                        'target_m_2','target_m_3','target_q','ach','ach_persen','status_reward','reward','no_rek','bank','nama_rekening','id_user_input'];
    protected $guarded = [];
}
