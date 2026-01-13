<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Vit_Compas_Co extends Model
{
    protected $table = 'import_vit_compas_co';
    protected $fillable = [
        'tgl_import',
        'plant',
        'distributor',
        'depo_tujuan',
        'sku',
        'co',
        'sj',
        'tgl_co',
        'tgl_real',
        'qty_co',
        'qty_real',
        'no_polisi',
        'sopir',
        'dn',
        'gr',
        'tl',
        'remark'
    ];
}
