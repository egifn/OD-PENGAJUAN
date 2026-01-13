<?php

namespace App\Imports;

use App\Import_Vit_Compas_Botol;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;

class ImportBotolKosong implements ToCollection, WithStartRow
{
	protected $startRow;

    public function __construct($startRow)
    {
        $this->startRow = $startRow;
        HeadingRowFormatter::default('none');
    }

    public function collection(Collection $rows)
    {
		foreach ($rows as $row) {
			if($row[2] != (NULL)){
				Import_Vit_Compas_Botol::create([
					'co' => $row[0],
					'tgl_import' => Carbon::now()->format('Y-m-d'),
					'tanggal_terima' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
					'plant' => $row[2],
					'distributor' => $row[3],
					'depo_tujuan' => $row[4],
					'sj' => $row[5],
					'sopir' => $row[6],
					'no_polisi' => $row[7],
					'dn' => $row[8],
					'gr' => $row[9],
					'tl' => $row[10],
					'ttl_btl_kosong' => $row[11],
					'ttl_tolakan_btl_kosong' => $row[12],
					'ttl_tolakan_retur' => $row[13],
					'ttl_btl_baik' => $row[14],
					'btl_kosong_afkir' => $row[15],
					'terima_aktif_retur' => $row[16],
					'terima_retur' => $row[17],
					'tolakan_asing' => $row[18],
					'tolakan_pecah' => $row[19],
					'tolakan_buram' => $row[20],
					'tolakan_rokok' => $row[21],
					'tolakan_bau' => $row[22],
					'tolakan_dekok' => $row[23],
					'tolakan_tambalan' => $row[24],
					'tolakan_lubang' => $row[25],
					'tolakan_noda' => $row[26],
					'tolakan_lain' => $row[27],
					'tolakan_retur_asing' => $row[28],
					'tolakan_retur_cacat' => $row[29],
					'tolakan_retur_seal_terbuka' => $row[30],
					'tolakan_retur_kotor' => $row[31],
					'tolakan_retur_lain' => $row[32],
					'afkir_retak_mulut' => $row[33],
					'afkir_retak_badan' => $row[34],
					'afkir_retak_dasar' => $row[35],
					'afkir_buram_usia' => $row[36],
					'afkir_lain_lain' => $row[37],
					'afkir_retur_retak_mulut' => $row[38],
					'afkir_retur_retak_badan' => $row[39],
					'afkir_retur_retak_dasar' => $row[40],
				]);
			}
		}
    }

	public function startRow(): int
    {
        return $this->startRow;
    }
}