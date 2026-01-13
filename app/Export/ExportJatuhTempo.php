<?php
namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Acc_DueDate;

class ExportJatuhTempo implements FromCollection
{
	public function collection()
	{
		return Acc_DueDate::all();
	}
}