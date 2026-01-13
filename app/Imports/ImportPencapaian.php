<?php
namespace App\Imports;

use App\ImportPencapaianProgramDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;

class ImportPencapaian implements ToModel, WithStartRow
{
    protected $startRow;

    private $no_urut;

    public function __construct($no_urut, $startRow)
    {
        $this->startRow = $startRow;
        HeadingRowFormatter::default('none');
        $this->no_urut = $no_urut;
    }
    //request()->kode
    public function model(array $row)
    {
        if($row[2] != (NULL)){
			$reward = $row[6];
            $reward_tiv = $row[7];

            if (empty($reward) || is_null($reward)) {
                $reward = 0; // Ubah ke 0 jika kosong atau null
            }

            if (empty($reward_tiv) || is_null($reward_tiv)) {
                $reward_tiv = 0; // Ubah ke 0 jika kosong atau null
            }
            
            return new ImportPencapaianProgramDetail([
                'tgl_import' => Carbon::now()->format('Y-m-d'),
                'no_surat' => request()->no_surat,
                'no_surat_tiv' => request()->no_surat_tiv,
                'kode_perusahaan' => $row[0], 
                'kode_depo' => '',
                'nama_depo' => $row[1],
                'kode_segmen' => '',
                'nama_segmen' => $row[2],
                'cluster' => $row[3],
                'kode_outlet' => $row[4],
                'nama_outlet' => $row[5],
                'qty' => 0,
                'reward' =>  $reward, //$row[6],
                'reward_tiv' => $reward_tiv, //$row[7],
                'total_reward' => $reward + $reward_tiv,//$row[6] + $row[7],
                'status' => 0,
                'no_urut' => $this->no_urut,
                'id_user_input' => Auth::user()->id
            ]);
        }
    }

    public function startRow(): int
    {
        return $this->startRow;
    }
}