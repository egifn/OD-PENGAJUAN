<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Vit_Compas_Botol extends Model
{
    protected $table = 'import_vit_compas_botol';
    protected $fillable = [
        'co',
        'tgl_import',
        'tanggal_terima',
        'plant',
        'distributor',
        'depo_tujuan',
        'sj',
        'sopir',
        'no_polisi',
        'dn',
        'gr',
        'tl',
        'ttl_btl_kosong',
        'ttl_tolakan_btl_kosong',
        'ttl_tolakan_retur',
        'ttl_btl_baik',
        'btl_kosong_afkir',
        'terima_aktif_retur',
        'terima_retur',
        'tolakan_asing',
        'tolakan_pecah',
        'tolakan_buram',
        'tolakan_rokok',
        'tolakan_bau',
        'tolakan_dekok',
        'tolakan_tambalan',
        'tolakan_lubang',
        'tolakan_noda',
        'tolakan_lain',
        'tolakan_retur_asing',
        'tolakan_retur_cacat',
        'tolakan_retur_seal_terbuka',
        'tolakan_retur_kotor',
        'tolakan_retur_lain',
        'afkir_retak_mulut',
        'afkir_retak_badan',
        'afkir_retak_dasar',
        'afkir_buram_usia',
        'afkir_lain_lain',
        'afkir_retur_retak_mulut',
        'afkir_retur_retak_badan',
        'afkir_retur_retak_dasar'
    ];
}
