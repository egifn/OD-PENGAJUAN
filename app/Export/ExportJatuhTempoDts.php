<?php
namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Acc_DueDate_dts;

class ExportJatuhTempo implements FromCollection
{
	public function collection()
	{
		return Acc_DueDate_dts::all();
	}
}