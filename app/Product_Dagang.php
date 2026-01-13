<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Dagang extends Model
{
    protected $table = 'product_dagang';
    protected $primaryKey = 'product_dagang';
    protected $keyType = 'string';
    protected $fillable = ['kode_produk','nama_produk','unit','kode_user_input'];
}
