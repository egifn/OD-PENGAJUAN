<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'categories_fin';
    protected $primaryKey = 'id_categories';
    protected $keyType = 'integer';
	protected $fillable = ['categories_name','id_user_input'];
}
