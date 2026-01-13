<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'kode';
    protected $keyType = 'string';
	protected $fillable = ['kode','nama_barang','category_id','merk','satuan','ket','price','stock','status_barang','kode_user_input','kode_user_update'];
    protected $guarded = [];
}
