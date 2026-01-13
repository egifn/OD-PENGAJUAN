<?php

namespace App\Imports;

use App\Import_Otm;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
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

class ImportOtm implements ToModel, WithStartRow, WithChunkReading, WithBatchInserts
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
            return new Import_Otm([
                'kode_otm_h' => request()->kode,
                'order_id' => $row[0],
                'shipment_id' => $row[1],
                'sap_order_no' => $row[2],
                'order_creation_date' => $row[3],
                'order_creation_reason' => $row[4],
                'order_type' => $row[5],
                'material_id' => $row[6],
                'material_desc' => $row[7],
                'source_id' => $row[8],
                'source_name' => $row[9],
                'dest_id' => $row[10],
                'dest_name' => $row[11],
                'sap_delivery_code' => $row[12],
                'storage_loc' => $row[13],
                'planned_transporter_id' => $row[14],
                'planned_transporter_name' => $row[15],
                'actual_transporter_id' => $row[16],
                'actual_transporter_name' => $row[17],
                'planned_quantity' => $row[18],
                'actual_quantity' => $row[19],
                'planned_pickup_date' => $row[20],
                'actual_pickup_date' => $row[21],
                'planned_window' => $row[22],
                'actual_window' => $row[23],
                'cancel_reason' => $row[24],
                'order_status' => $row[25],
                'dispatch_number' => $row[26],
                'order_approval_status' => $row[27],
                'shipment_tatus' => $row[28],
                'dn_number' => $row[29],
                'truck_type' => $row[30],
                'id_user_input' => Auth::user()->id
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