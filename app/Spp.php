<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    protected $table = 'spp';
    protected $fillable = ['no_urut','no_spp','tgl_spp','no_kontrabon','kode_pembelian','ditujukan','kode_vendor','for','jumlah','jatuh_tempo','keterangan','jenis','status','id_user_input','kode_user_input_spp','kode_perusahaan','kode_depo','sumber_dana','pajak_masukan','pembayaran','yang_mengajukan','status_pajak','id_user_approval_spp_1','kode_approved_spp_1','tgl_approval_spp_1','status_spp_1','id_user_approval_spp_2','kode_approved_spp_2','tgl_approval_spp_2','status_spp_2','kategori','no_group','metode_pembayaran'];
}
