<?php
namespace App\Imports;

use App\ImportSapTagihanTiv;
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

class ImportTagihanTiv implements ToModel, WithStartRow, WithChunkReading, WithBatchInserts
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
                $invoiceDate = $this->transformDate($row[2]);
                $issueDate   = $this->transformDate($row[3]);

                return new ImportSapTagihanTiv([
                    'tgl_import' => Carbon::now()->format('Y-m-d'),
                    'purchase_order_number' => $row[0],
                    'order_number' => $row[1],
                    'invoice_date' => $invoiceDate, 
                    'actual_goods_issue_date' => $issueDate,
                    'sales_document_type' => $row[4],
                    'ship_to' => $row[5],
                    'sold_to_party' => $row[6],
                    'plant' => $row[7],
                    'plant_description' => $row[8],
                    'delivery_number' => $row[9],
                    'material_id' => $row[10],
                    'external_delivery_id' =>  $row[11],
                    'means_of_trans_id' => $row[12],
                    'ship_to_name' => $row[13],
                    'sold_to_name' => $row[14],
                    'material_description' => $row[15],
                    'billing_document' => $row[16],
                    'delivery_sum' => $row[17], 
                    'invoice_cab' => $row[18],
                    'invoice_caf' => $row[19],
                    'invoice_vat_amount' => $row[20],
                    'subsidi' => $row[21],
                    'original_amount' => $row[22],
                    'id_user_input' => Auth::user()->id
                ]);
            }
            return null;
    }

    protected function transformDate($value)
    {
        if (is_numeric($value)) {
            return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
        }
        
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Atau log error jika perlu
        }
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