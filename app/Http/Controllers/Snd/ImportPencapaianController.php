<?php

namespace App\Http\Controllers\Snd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;
use Excel;
use Barryvdh\DomPDF\Facade as PDF;
use App\Imports\ImportPencapaian;
use App\Imports\ImportPencapaianEdit;
use App\ImportPencapaianProgramUpload;
use App\ImportPencapaianProgramDetailUpdate;

class ImportPencapaianController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data = DB::table('import_pencapaian_program_header')
					->join('claim_surat_program', function($join) {
                        $join->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat')
                            ->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program');
                    })
                    ->leftJoin('pengajuan_biaya','import_pencapaian_program_header.no_surat','=','pengajuan_biaya.no_surat_program')
                    ->leftJoin('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
					->select(
                                'import_pencapaian_program_header.tgl_import',
                                'import_pencapaian_program_header.no_surat',
                                'import_pencapaian_program_header.id_program',
								'claim_surat_program.nama_program',
                                'import_pencapaian_program_header.kode_perusahaan',
                                'import_pencapaian_program_header.keterangan',
								'pengajuan_biaya_detail.keterangan_detail_clm',
                                'import_pencapaian_program_header.no_urut',
                                'import_pencapaian_program_header.status',
                                'import_pencapaian_program_header.id_user_input')
                    ->where('import_pencapaian_program_header.tgl_import', [$date_start,$date_end])
                    ->where('import_pencapaian_program_header.id_user_input', Auth::user()->id)
					->groupBy(
                                'import_pencapaian_program_header.tgl_import',
                                'import_pencapaian_program_header.no_surat',
                                'import_pencapaian_program_header.id_program',
								'claim_surat_program.nama_program',
                                'import_pencapaian_program_header.kode_perusahaan',
                                'import_pencapaian_program_header.keterangan',
								'pengajuan_biaya_detail.keterangan_detail_clm',
                                'import_pencapaian_program_header.no_urut',
                                'import_pencapaian_program_header.status',
                                'import_pencapaian_program_header.id_user_input')
					->orderBy('import_pencapaian_program_header.tgl_import', 'DESC')
                    ->get();


        return view('snd.import_pencapaian.index', compact('data'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }


        $data = DB::table('import_pencapaian_program_header')
					->join('claim_surat_program', function($join) {
                        $join->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat')
                            ->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program');
                    })
                    ->leftJoin('pengajuan_biaya','import_pencapaian_program_header.no_surat','=','pengajuan_biaya.no_surat_program')
                    ->leftJoin('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
					->select(
                                'import_pencapaian_program_header.tgl_import',
                                'import_pencapaian_program_header.no_surat',
                                'import_pencapaian_program_header.id_program',
								'claim_surat_program.nama_program',
                                'import_pencapaian_program_header.kode_perusahaan',
                                'import_pencapaian_program_header.keterangan',
								'pengajuan_biaya_detail.keterangan_detail_clm',
                                'import_pencapaian_program_header.no_urut',
                                'import_pencapaian_program_header.status',
                                'import_pencapaian_program_header.id_user_input')
                    ->WhereBetween('import_pencapaian_program_header.tgl_import', [$date_start,$date_end])
                    ->where('import_pencapaian_program_header.id_user_input', Auth::user()->id)
					->groupBy(
                                'import_pencapaian_program_header.tgl_import',
                                'import_pencapaian_program_header.no_surat',
                                'import_pencapaian_program_header.id_program',
								'claim_surat_program.nama_program',
                                'import_pencapaian_program_header.kode_perusahaan',
                                'import_pencapaian_program_header.keterangan',
								'pengajuan_biaya_detail.keterangan_detail_clm',
                                'import_pencapaian_program_header.no_urut',
                                'import_pencapaian_program_header.status',
                                'import_pencapaian_program_header.id_user_input')
					->orderBy('import_pencapaian_program_header.tgl_import', 'DESC')
                    ->get();

        return view('snd.import_pencapaian.index', compact('data'));

    }

    public function create()
    {
        return view('snd.import_pencapaian.import_pencapaian');        
    }

    public function actionSuratProgram(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            
            
            if($query != ''){
                $data = DB::table('claim_surat_program')
                        ->leftJoin('claim_surat_program_detail','claim_surat_program.no_urut','=','claim_surat_program_detail.no_urut')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','claim_surat_program.tgl_upload_kirim','claim_surat_program.jenis_surat',
                                'claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir','claim_surat_program.kategori',
                                'claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.status')
                        ->where('claim_surat_program.status', 0)
                        ->Where('claim_surat_program.no_surat','like','%'.$query.'%')
                        ->orWhere('claim_surat_program.id_program','like','%'.$query.'%')
                        ->orWhere('claim_surat_program.nama_program','like','%'.$query.'%')
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','claim_surat_program.tgl_upload_kirim','claim_surat_program.jenis_surat',
                                'claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir','claim_surat_program.kategori',
                                'claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.status')
                        ->get();
            }else{
                $data = DB::table('claim_surat_program')
                        ->leftJoin('claim_surat_program_detail','claim_surat_program.no_urut','=','claim_surat_program_detail.no_urut')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','claim_surat_program.tgl_upload_kirim','claim_surat_program.jenis_surat',
                                'claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir','claim_surat_program.kategori',
                                'claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.status')
                        ->where('claim_surat_program.status', 0)
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','claim_surat_program.tgl_upload_kirim','claim_surat_program.jenis_surat',
                                'claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir','claim_surat_program.kategori',
                                'claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.status')
                        ->get();
            }
            
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih" data-id="'.$row->id.'" data-no_surat="'.$row->no_surat.'" data-kode_perusahaan="'.$row->kode_perusahaan.'" data-tgl_upload="'.$row->tgl_upload_kirim.'" data-jenis_surat="'.$row->jenis_surat.'" data-id_program="'.$row->id_program.'" data-nama_program="'.$row->nama_program.'" data-kategori="'.$row->kategori.'" data-awal="'.$row->periode_awal.'" data-akhir="'.$row->periode_akhir.'" data-sku="'.$row->sku.'" data-segmen="'.$row->segmen.'" data-status="'.$row->status.'">
                            <td hidden>'.$row->id.'</td>
                            <td>'.$row->no_surat.'</td>
                            <td>'.''.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->id_program.'</td>
                            <td>'.$row->nama_program.'</td>
                            <td>'.$row->kategori.'</td>
                            <td hidden>'.$row->tgl_upload_kirim.'</td>
                            <td hidden>'.$row->periode_awal.'</td>
                            <td hidden>'.$row->periode_akhir.'</td>
                            <td hidden>'.$row->sku.'</td>
                            <td hidden>'.$row->segmen.'</td>
                            <td hidden>'.$row->status.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {

        $cari_no_urut = DB::table('import_pencapaian_program_header')->select(DB::raw('COUNT(no_surat) as NoUrut'))->first();
        if ($cari_no_urut->NoUrut > 0) {
            $no_urut = $cari_no_urut->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        DB::table('import_pencapaian_program_header')->insert([
            'tgl_import' => Carbon::now()->format('Y-m-d'),
        	'no_surat' => $request->get('no_surat'), 
            'no_surat_tiv' => $request->get('no_surat_tiv'),
        	'id_program' => $request->get('id_program'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kategori' => $request->get('kategori'),
        	'keterangan' => $request->get('keterangan'),
        	'no_urut' => $no_urut,
            'status' => 0,
        	'id_user_input' => Auth::user()->id
        ]);

        if($request->hasFile('file'))
        {
            $startRow = $request->input('start_row', 2); // Dapatkan nilai startRow dari request
            $file = $request->file('file');
            $import = new ImportPencapaian($no_urut, $startRow); // Inisialisasi dengan 2 argumen

            $importResult = Excel::import($import, $file);

            // if ($importResult) {
            //     return redirect()->back()->with('success', 'File Excel berhasil diimpor.');
            // } else {
            //     return redirect()->back()->with('error', 'Gagal mengimpor file Excel.');
            // }
        }

        //upload file Surat Program dari TIV===============================================================================
        if($request->hasfile('file_upload')) { 
            foreach ($request->file('file_upload') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);
                       
                    ImportPencapaianProgramUpload::create([
                        'no_urut' => $no_urut,
                        'id_program' => $request->get('id_program'),
                        'filename' => $filename
                    ]);
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }

        //update tabel "claim_surat_program"==============//
        $approved = DB::table('claim_surat_program')->where('no_urut', $no_urut)
							->update([
								'status' => 0
							]);
        //================================================//

        alert()->success('Success.','Eksekusi proses berhasil...');
        return redirect()->route('import_pencapaian.index');

    }

    public function view($no_urut)
    {
        $data_header = DB:: table('import_pencapaian_program_header')
                            ->select('import_pencapaian_program_header.tgl_import','import_pencapaian_program_header.no_surat','import_pencapaian_program_header.id_program','import_pencapaian_program_header.kategori','import_pencapaian_program_header.keterangan')
                            ->where('import_pencapaian_program_header.no_urut', $no_urut)
                            ->first();

        $data = DB::table('import_pencapaian_program_header')
                            ->join('import_pencapaian_program_detail','import_pencapaian_program_header.no_urut','=','import_pencapaian_program_detail.no_urut')
                            ->select('import_pencapaian_program_header.no_surat','import_pencapaian_program_header.tgl_import','import_pencapaian_program_header.id_program',
                                    'import_pencapaian_program_header.keterangan','import_pencapaian_program_header.no_urut',
                                    'import_pencapaian_program_detail.kode_depo','import_pencapaian_program_detail.nama_depo','import_pencapaian_program_detail.kode_segmen',
                                    'import_pencapaian_program_detail.nama_segmen','import_pencapaian_program_detail.cluster','import_pencapaian_program_detail.kode_outlet',
                                    'import_pencapaian_program_detail.nama_outlet','import_pencapaian_program_detail.qty','import_pencapaian_program_detail.reward','import_pencapaian_program_detail.reward_tiv',
                                    'import_pencapaian_program_detail.total_reward','import_pencapaian_program_detail.status')
                            ->where('import_pencapaian_program_header.no_urut', $no_urut)
                            ->get();

        $data_total = DB::table('import_pencapaian_program_detail')
                        ->select(DB::raw('SUM(import_pencapaian_program_detail.reward) as total_dist'),
                                 DB::raw('SUM(import_pencapaian_program_detail.reward_tiv) as total_tiv'),
                                 DB::raw('SUM(import_pencapaian_program_detail.total_reward) as total_reward'))
                        ->where('import_pencapaian_program_detail.no_urut', $no_urut)
                        ->groupBy('import_pencapaian_program_detail.no_urut')
                        ->first();
		
		$approval_upload = DB::table('import_pencapaian_program_upload')
                        ->select('import_pencapaian_program_upload.filename')
                        ->where('import_pencapaian_program_upload.id_program', $data_header->id_program)
                        ->get();

        return view('snd.import_pencapaian.view', compact('data_header', 'data', 'data_total','approval_upload'));

        // return view('snd.upload_kirim.view', compact('data_claim_program','segmenArrayToString','skuArrayToString','data_claim_program_detail_ta','data_claim_program_detail_tu','data_claim_program_detail_tua',
        //'data_upload_program_tiv','data_upload_pendukung','data_upload_program_tua','data_upload_program_tu','data_upload_program_ta'));
    }
	
	public function update_data(Request $request, $no_urut)
    {
        $header = DB:: table('import_pencapaian_program_header')
                            ->join('claim_surat_program','import_pencapaian_program_header.no_surat','=','claim_surat_program.no_surat')
                            ->select('import_pencapaian_program_header.no_urut',
                                'import_pencapaian_program_header.tgl_import',
                                'import_pencapaian_program_header.no_surat',
                                'import_pencapaian_program_header.no_surat_tiv',
                                'import_pencapaian_program_header.kode_perusahaan',
                                'import_pencapaian_program_header.kategori',
                                'import_pencapaian_program_header.id_program',
                                'claim_surat_program.nama_program',
                                'import_pencapaian_program_header.keterangan')
                            ->where('import_pencapaian_program_header.no_urut', $no_urut)
                            ->first();

        $detail = DB::table('import_pencapaian_program_header')
                            ->join('import_pencapaian_program_detail','import_pencapaian_program_header.no_surat','=','import_pencapaian_program_detail.no_surat')
                            ->select('import_pencapaian_program_header.no_surat','import_pencapaian_program_header.tgl_import','import_pencapaian_program_header.id_program',
                                    'import_pencapaian_program_header.keterangan','import_pencapaian_program_header.no_urut',
                                    'import_pencapaian_program_detail.kode_depo','import_pencapaian_program_detail.nama_depo','import_pencapaian_program_detail.kode_segmen',
                                    'import_pencapaian_program_detail.nama_segmen','import_pencapaian_program_detail.cluster','import_pencapaian_program_detail.kode_outlet',
                                    'import_pencapaian_program_detail.nama_outlet','import_pencapaian_program_detail.qty','import_pencapaian_program_detail.reward','import_pencapaian_program_detail.reward_tiv',
                                    'import_pencapaian_program_detail.total_reward','import_pencapaian_program_detail.status')
                            ->where('import_pencapaian_program_header.no_urut', $no_urut)
                            ->get();

        $data_pencapaian = DB::table('import_pencapaian_program_upload')
                                ->where('import_pencapaian_program_upload.no_urut', $no_urut)
                                ->get();

        return view ('snd.import_pencapaian.edit', compact('header','detail','data_pencapaian'));
    }

    public function edit(Request $request)
    {

        //Insert data ke table history update//
        $date = (date('Ym'));
        $date_1 = (date('Ymd'));

        $getRow = DB::table('import_pencapaian_program_header_update')->select(DB::raw('MAX(RIGHT(kode_update,6)) as NoUrut'))
                                        ->where('kode_update', 'like', "%".$date."%");
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode_update = $date_1."00000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $kode_update = $date_1."0000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $kode_update = $date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $kode_update = $date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $kode_update = $date_1."0".''.($rowCount + 1);
            } else {
                    $kode_update = $date_1.($rowCount + 1);
            }
        }else{
            $kode_update = $date_1.sprintf("%06s", 1);
        }
        DB::table('import_pencapaian_program_header_update')->insert([
            'kode_update' => $kode_update,
            'tgl_update' => Carbon::now()->format('Y-m-d'),
        	'no_surat' => $request->get('no_surat_history'), 
            'no_surat_tiv' => $request->get('no_surat_tiv_history'),
        	'id_program' => $request->get('id_program_history'),
            'kode_perusahaan' => $request->get('kode_perusahaan_history'),
            'kategori' => $request->get('kategori_history'),
        	'keterangan' => $request->get('keterangan_history'),
            'no_urut' => $request->get('no_urut'),
        	'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('no') as $key => $value) {
           
        }

        $validator = Validator::make($request->all(), $datas);
        foreach ($request->input("no") as $key => $value) {
            $data = new ImportPencapaianProgramDetailUpdate();
            $data->kode_update = $kode_update;
            $data->no_surat = $request->get("no_surat")[$key];
            $data->no_surat_tiv = $request->get('no_surat_tiv_history');
            $data->kode_perusahaan = $request->get('kode_perusahaan');
            // $data->kode_depo = '';
            $data->nama_depo = $request->get("nama_depo")[$key];
            // $data->kode_segmen = $rowData[0];
            $data->nama_segmen = $request->get("nama_segmen")[$key];
            $data->cluster = $request->get("cluster")[$key];
            $data->kode_outlet = $request->get("kode_outlet")[$key];
            $data->nama_outlet = $request->get("nama_outlet")[$key];
            // $data->qty = $rowData[0];
            $data->reward = str_replace(",", "", $request->get("reward")[$key]);
            $data->reward_tiv = str_replace(",", "", $request->get("reward_tiv")[$key]);
            $data->total_reward = str_replace(",", "", $request->get("reward")[$key]) + str_replace(",", "", $request->get("reward_tiv")[$key]);
            $data->no_urut = $request->get('no_urut');
            $data->id_user_input = Auth::user()->id;
            $data->save();
        }

        //Update data ke table//
        $data_revisi = DB::table('import_pencapaian_program_header')->where('no_urut', $request->get('no_urut'))
                ->update([
                    'tgl_import' => Carbon::now()->format('Y-m-d'),
                    'no_surat' => $request->get('no_surat_dist'),
                    'no_surat_tiv' => $request->get('no_surat_tiv'),
                    'id_program' => $request->get('id_program'),
                    'kode_perusahaan' => $request->get('kode_perusahaan'),
                    'kategori' => $request->get('kategori'),
                    'status' =>'0',
                    'id_user_input' => Auth::user()->id,
                    'status_app_manager' => 0,
                    'id_user_manager' => (NULL),
                    'status_app_som' => 0,
                    'id_user_som' => (NULL),
                ]);
        
        //delete data detail lama//
        DB::table('import_pencapaian_program_detail')
                     ->where('no_urut', $request->get('no_urut'))
                     ->delete();

        $no_urut = $request->get('no_urut');
        if($request->hasFile('file'))
        {
            $startRow = $request->input('start_row', 2); // Dapatkan nilai startRow dari request
            $file = $request->file('file');
            $import = new ImportPencapaianEdit($no_urut, $startRow); // Inisialisasi dengan 2 argumen
        
            $importResult = Excel::import($import, $file);
        }

        //upload file Surat Program dari TIV===============================================================================
        if($request->hasfile('file_upload')) { 
            foreach ($request->file('file_upload') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);
                    
                    $existingData = ImportPencapaianProgramUpload::where('no_urut', $request->get('no_urut'))->first();
                    if ($existingData) {
                        // Jika data sudah ada, lakukan pembaruan
                        $existingData->update([
                            'id_program' => $request->get('id_program'),
                            'filename' => $filename
                        ]);
                    } else {
                        // Jika data belum ada, buat data baru
                        ImportPencapaianProgramUpload::create([
                            'no_urut' => $request->get('no_urut'),
                            'id_program' => $request->get('id_program'),
                            'filename' => $filename
                        ]);
                    }
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }
        
        alert()->success('Success.','Eksekusi proses update berhasil...');
        return redirect()->route('import_pencapaian.index');
    }
}
