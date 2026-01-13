<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $primaryKey = 'kode_vendor';
    protected $keyType = 'string';
    protected $fillable = ['kode_vendor','nama_vendor','alamat','telp','fax','email','contact_person','jabatan','top','tgl_mulai','tgl_selesai','status_1','status_2','memo','tgl_memo','approved_by','tgl_approved','keterangan','id_user_input','id_user_update'];
}
