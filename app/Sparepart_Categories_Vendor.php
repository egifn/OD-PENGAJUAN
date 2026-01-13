<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart_Categories_Vendor extends Model
{
    protected $table = 'sparepart_categories_vendor';
    protected $primaryKey = 'kode_kategori_vendor';
    protected $keyType = 'string';
    protected $fillable = ['kode_kategori_vendor','nama_kategori_vendor'];
}
