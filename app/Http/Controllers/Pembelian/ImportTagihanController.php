<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportTagihanTiv;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;
use Excel;

class ImportTagihanController extends Controller
{
    public function index()
    {

        return view('pembelian.tagihan_tiv.index');
    }

    public function storeData(Request $request)
    {
        set_time_limit(0); // Tanpa batas waktu

        if($request->hasFile('file'))
        {
            $startRow = $request->input('start_row', 2); // Dapatkan nilai startRow dari request
            $file = $request->file('file');
            $import = new ImportTagihanTiv($startRow); // Inisialisasi dengan 2 argumen

            try {
                Excel::import($import, $file);
                return redirect()->back()->with('success', 'File Excel berhasil diimpor.');
            } catch (\Throwable $e) {
                return redirect()->back()->with('error', 'Gagal impor: ' . $e->getMessage());
            }
        }
        return redirect()->back()->with('error', 'File tidak ditemukan.');

    }
}
