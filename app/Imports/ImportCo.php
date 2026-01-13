<?php

namespace App\Imports;

use App\Import_Vit_Compas_Co;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;

class ImportCo implements ToModel, WithStartRow, WithChunkReading, WithBatchInserts
{
	protected $startRow;

    public function __construct($startRow)
    {
        $this->startRow = $startRow;
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
		if($row[2] != (NULL)){
			return new Import_Vit_Compas_Co([
				'tgl_import' => Carbon::now()->format('Y-m-d'),
				'plant' => $row[0],
				'distributor' => $row[1],
				'depo_tujuan' => $row[2],
				'sku' => $row[3],
				'co' => $row[4],
				'sj' => $row[5],
				'tgl_co' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
				'tgl_real' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7]),
				'qty_co' => $row[8],
				'qty_real' => $row[9],
				'no_polisi' => $row[10],
				'sopir' => $row[11],
				'dn' => $row[12],
				'gr' => $row[13],
				'tl' => $row[14],
				'remark' => $row[15]
			]);
		}
		return null;
    }

	public function startRow(): int
    {
        return $this->startRow;
    }

    public function chunkSize(): int
    {
        return 1000; // Atur sesuai kebutuhan
    }

    public function batchSize(): int
    {
        return 1000; // Insert 1000 data sekaligus
    }

}