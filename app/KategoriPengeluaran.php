<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriPengeluaran extends Model
{
    protected $table = 'categories_fin_sub';
    protected $primaryKey = 'id_sub_categories';
    protected $keyType = 'integer';
	protected $fillable = ['id_categories','sub_categories_name','id_user_input'];
}
