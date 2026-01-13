<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TransferProgramClaimHis extends Controller
{
    public function index()
    {
        return view ('finance.transfer.program_claim_history.index');
    }

    public function showView($no_urut)
    { 
        $data_transfer_head = DB::table('import_pencapaian_program_header')
                            ->select('import_pencapaian_program_header.no_urut_pengajuan',
                                    'import_pencapaian_program_header.no_surat',
                                    'import_pencapaian_program_header.id_program',
                                    'import_pencapaian_program_header.kode_perusahaan',
                                    'data_transfer.nama_perusahaan',
                                    'data_transfer.nama_bank',
                                    'data_transfer.norek',
                                    'data_transfer.keterangan')
                            ->join('data_transfer', function ($join) {
                                $join->on('import_pencapaian_program_header.no_surat','=','data_transfer.no_surat_program')
                                    ->on('import_pencapaian_program_header.id_program','=','data_transfer.id_program_ssd')
                                    ->on('import_pencapaian_program_header.kode_perusahaan','=','data_transfer.kode_perusahaan_program');
                            })
							->join('pengajuan_biaya','data_transfer.kode_pengajuan_b','=', 'pengajuan_biaya.kode_pengajuan_b')
                            ->where('import_pencapaian_program_header.no_urut_pengajuan', $no_urut)
							->where('pengajuan_biaya.no_urut', $no_urut)
                            ->first();

        $data_list_transfer = DB::table('pengajuan_biaya')
                ->select('pengajuan_biaya.kode_pengajuan_b', 
				'pengajuan_biaya.tgl_pengajuan_b', 
				'pengajuan_biaya.kode_perusahaan_tujuan', 
				'pengajuan_biaya.no_surat_program', 
				'pengajuan_biaya.id_program', 
				'pengajuan_biaya.keterangan AS keterangan_biaya',
                'import_pencapaian_program_header.tgl_import',
				'import_pencapaian_program_header.no_surat AS no_surat_header', 
				'import_pencapaian_program_header.kode_perusahaan AS kode_perusahaan_header', 
				'import_pencapaian_program_header.kategori',
                'import_pencapaian_program_header.keterangan AS keterangan_program', 
				'import_pencapaian_program_header.id_program AS id_program_ssd', 
				'claim_surat_program.nama_program',
                'import_pencapaian_program_detail.no_surat AS no_surat_detail', 
				'import_pencapaian_program_detail.kode_perusahaan AS kode_perusahaan_detail', 
				'import_pencapaian_program_detail.nama_depo',
                'import_pencapaian_program_detail.nama_segmen', 
				'import_pencapaian_program_detail.cluster', 
				'import_pencapaian_program_detail.kode_outlet', 
				'import_pencapaian_program_detail.nama_outlet',
                'rekening_outlet.bank_rekening',
				'rekening_outlet.no_rekening',
				'rekening_outlet.nama_rekening',
                'import_pencapaian_program_detail.reward', 
				'import_pencapaian_program_detail.reward_tiv', 
				'import_pencapaian_program_detail.total_reward', 
                DB::raw("CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' WHEN rekening_outlet.bank_rekening = '#N/A' THEN '0' ELSE '2900' END AS potongan"),
                DB::raw("import_pencapaian_program_detail.total_reward - (CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' WHEN rekening_outlet.bank_rekening = '#N/A' THEN '0' ELSE '2900' END) AS total"),
                'import_pencapaian_program_detail.no_urut',
				'list_piutang_toko.piutang_depo', 
				'list_piutang_toko.norek_depo', 
				'banks.nama_bank AS nama_bank_depo', 
				'list_piutang_toko.piutang_ng', 
				'list_piutang_toko.norek_ng',
                'banks_ng.nama_bank AS nama_bank_ng')
                ->join('import_pencapaian_program_header', function ($join) {
                    $join->on('pengajuan_biaya.no_surat_program', '=', 'import_pencapaian_program_header.no_surat')
                        ->on('pengajuan_biaya.id_program', '=', 'import_pencapaian_program_header.id_program')
                        ->on('pengajuan_biaya.kode_perusahaan_tujuan', '=', 'import_pencapaian_program_header.kode_perusahaan');
                })
                ->join('claim_surat_program', function ($join) {
					$join->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program')
						->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat');
				}) 
                ->join('import_pencapaian_program_detail', function ($join) {
                    $join->on('import_pencapaian_program_header.no_surat', '=', 'import_pencapaian_program_detail.no_surat')
                        ->on('import_pencapaian_program_header.kode_perusahaan', '=', 'import_pencapaian_program_detail.kode_perusahaan');
                })
                ->leftJoin('pengajuan_biaya_claim_piutang', function ($join) {
                    $join->on('pengajuan_biaya.kode_pengajuan_b', '=', 'pengajuan_biaya_claim_piutang.kode_pengajuan_b')
                        ->on('pengajuan_biaya.kode_perusahaan', '=', 'pengajuan_biaya_claim_piutang.kode_perusahaan');
                })
                ->leftJoin('pengajuan_biaya_claim_piutang AS list_piutang_toko', function ($join) {
                    $join->on('import_pencapaian_program_detail.no_surat', '=', 'list_piutang_toko.no_surat')
                        ->on('import_pencapaian_program_detail.kode_perusahaan', '=', 'list_piutang_toko.kode_perusahaan')
                        ->on('import_pencapaian_program_detail.kode_outlet', '=', 'list_piutang_toko.id_toko');
                })
                ->leftJoin('rekening_fin_comp', 'list_piutang_toko.norek_depo', '=', 'rekening_fin_comp.norek')
                ->leftJoin('banks', 'rekening_fin_comp.kode_bank', '=', 'banks.kode_bank')
                ->leftJoin('rekening_fin_comp AS rekening_fin_comp_ng', 'list_piutang_toko.norek_ng', '=', 'rekening_fin_comp_ng.norek')
                ->leftJoin('banks AS banks_ng', 'rekening_fin_comp_ng.kode_bank', '=', 'banks_ng.kode_bank')
                ->leftJoin('rekening_outlet', 'import_pencapaian_program_detail.kode_outlet', '=', 'rekening_outlet.kode_toko')
                ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                ->where('import_pencapaian_program_detail.status', 1)
				->where('pengajuan_biaya.no_urut', $no_urut)
				->where('import_pencapaian_program_header.no_urut_pengajuan', $no_urut)
				->where('import_pencapaian_program_detail.no_urut_pengajuan', $no_urut)
				->groupBy('pengajuan_biaya.kode_pengajuan_b', 
				'pengajuan_biaya.tgl_pengajuan_b', 
				'pengajuan_biaya.kode_perusahaan_tujuan', 
				'pengajuan_biaya.no_surat_program', 
				'pengajuan_biaya.id_program', 
				'pengajuan_biaya.keterangan',
                'import_pencapaian_program_header.tgl_import',
				'import_pencapaian_program_header.no_surat', 
				'import_pencapaian_program_header.kode_perusahaan', 
				'import_pencapaian_program_header.kategori',
                'import_pencapaian_program_header.keterangan', 
				'import_pencapaian_program_header.id_program', 
				'claim_surat_program.nama_program',
                'import_pencapaian_program_detail.no_surat', 
				'import_pencapaian_program_detail.kode_perusahaan', 
				'import_pencapaian_program_detail.nama_depo',
                'import_pencapaian_program_detail.nama_segmen', 
				'import_pencapaian_program_detail.cluster', 
				'import_pencapaian_program_detail.kode_outlet', 
				'import_pencapaian_program_detail.nama_outlet',
                'rekening_outlet.bank_rekening',
				'rekening_outlet.no_rekening',
				'rekening_outlet.nama_rekening',
                'import_pencapaian_program_detail.reward', 
				'import_pencapaian_program_detail.reward_tiv', 
				'import_pencapaian_program_detail.total_reward', 
                'import_pencapaian_program_detail.no_urut',
				'list_piutang_toko.piutang_depo', 
				'list_piutang_toko.norek_depo', 
				'banks.nama_bank', 
				'list_piutang_toko.piutang_ng', 
				'list_piutang_toko.norek_ng',
                'banks_ng.nama_bank')
                ->orderBy('import_pencapaian_program_detail.nama_outlet', 'ASC')
                ->get();

        return view('finance.transfer.program_claim_history.view', compact('data_list_transfer','data_transfer_head'));
    }

    public function getData(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
		$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_transfer = DB::table('pengajuan_biaya')
                ->select(
                    'pengajuan_biaya.kode_pengajuan_b',
                    
                    'pengajuan_biaya.kode_perusahaan_tujuan',
                    'pengajuan_biaya.no_surat_program',
                    'pengajuan_biaya.id_program',
                    'claim_surat_program.nama_program',
                    'pengajuan_biaya_detail.harga AS reward_distributor',
                    'pengajuan_biaya_detail.jml_harga AS reward_tiv',
                    'pengajuan_biaya_detail.potongan AS potongan',
                    'pengajuan_biaya_detail.tharga AS total_reward',
					'pengajuan_biaya.no_urut'
                )
				
				->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('import_pencapaian_program_header', function ($join) {
                    $join->on('pengajuan_biaya.no_surat_program', '=', 'import_pencapaian_program_header.no_surat')
                        ->on('pengajuan_biaya.id_program', '=', 'import_pencapaian_program_header.id_program')
                        ->on('pengajuan_biaya.kode_perusahaan_tujuan', '=', 'import_pencapaian_program_header.kode_perusahaan');
                })
                ->join('claim_surat_program', 'import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program')
                ->join('import_pencapaian_program_detail', function ($join) {
                    $join->on('import_pencapaian_program_header.no_surat', '=', 'import_pencapaian_program_detail.no_surat')
                        ->on('import_pencapaian_program_header.kode_perusahaan', '=', 'import_pencapaian_program_detail.kode_perusahaan');
                })
                ->leftJoin('rekening_outlet', 'import_pencapaian_program_detail.kode_outlet', '=', 'rekening_outlet.kode_toko')
                ->groupBy('pengajuan_biaya.kode_pengajuan_b',
                    
                    'pengajuan_biaya.kode_perusahaan_tujuan',
                    'pengajuan_biaya.no_surat_program',
                    'pengajuan_biaya.id_program',
                    'claim_surat_program.nama_program',
                    'pengajuan_biaya_detail.harga',
                    'pengajuan_biaya_detail.jml_harga',
                    'pengajuan_biaya_detail.potongan',
                    'pengajuan_biaya_detail.tharga',
					'pengajuan_biaya.no_urut'
					);
        if (!isset($request->value)) {
            $data_transfer
						->whereBetween('pengajuan_biaya.tgl_approval_spp_2', [$date_start,$date_end])
                        ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                        //->where('pengajuan_biaya.status_payment','0')
						->where('pengajuan_biaya.status_spp_2','1')
                        ->where('import_pencapaian_program_detail.status','1');
                        // ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
        }else{
            $data_transfer
						->whereBetween('pengajuan_biaya.tgl_approval_spp_2', [$date_start,$date_end])
                        ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                        //->where('pengajuan_biaya.status_payment','0')
						->where('pengajuan_biaya.status_spp_2','1')
                        ->where('import_pencapaian_program_detail.status','1');
                        // ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                        // ->Where('izin_h.no_izin', 'like', "%$request->value%")
                        // ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                        // ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
        }

        $data  = $data_transfer->get();
        $count = ($data_transfer->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

	public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ' ,$request->tgl_cari);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');

        $data_transfer = DB::table('pengajuan_biaya')
                ->select(
                    'pengajuan_biaya.kode_pengajuan_b',
                    
                    'pengajuan_biaya.kode_perusahaan_tujuan',
                    'pengajuan_biaya.no_surat_program',
                    'pengajuan_biaya.id_program',
                    'claim_surat_program.nama_program',
                    'pengajuan_biaya_detail.harga AS reward_distributor',
                    'pengajuan_biaya_detail.jml_harga AS reward_tiv',
                    'pengajuan_biaya_detail.potongan AS potongan',
                    'pengajuan_biaya_detail.tharga AS total_reward',
					'pengajuan_biaya.no_urut'
                )
				
				->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('import_pencapaian_program_header', function ($join) {
                    $join->on('pengajuan_biaya.no_surat_program', '=', 'import_pencapaian_program_header.no_surat')
                        ->on('pengajuan_biaya.id_program', '=', 'import_pencapaian_program_header.id_program')
                        ->on('pengajuan_biaya.kode_perusahaan_tujuan', '=', 'import_pencapaian_program_header.kode_perusahaan');
                })
                ->join('claim_surat_program', 'import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program')
                ->join('import_pencapaian_program_detail', function ($join) {
                    $join->on('import_pencapaian_program_header.no_surat', '=', 'import_pencapaian_program_detail.no_surat')
                        ->on('import_pencapaian_program_header.kode_perusahaan', '=', 'import_pencapaian_program_detail.kode_perusahaan');
                })
                ->leftJoin('rekening_outlet', 'import_pencapaian_program_detail.kode_outlet', '=', 'rekening_outlet.kode_toko')
                ->groupBy('pengajuan_biaya.kode_pengajuan_b',
                    
                    'pengajuan_biaya.kode_perusahaan_tujuan',
                    'pengajuan_biaya.no_surat_program',
                    'pengajuan_biaya.id_program',
                    'claim_surat_program.nama_program',
                    'pengajuan_biaya_detail.harga',
                    'pengajuan_biaya_detail.jml_harga',
                    'pengajuan_biaya_detail.potongan',
                    'pengajuan_biaya_detail.tharga',
					'pengajuan_biaya.no_urut'
					);
        if (!isset($request->value)) {
            $data_transfer
                        ->whereBetween('pengajuan_biaya.tgl_approval_spp_2', [$date_start,$date_end])
                        ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                        //->where('pengajuan_biaya.status_payment','0')
						->where('pengajuan_biaya.status_spp_2','1')
                        ->where('import_pencapaian_program_detail.status','1');
                        // ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
        }else{
            $data_transfer
                        ->whereBetween('pengajuan_biaya.tgl_approval_spp_2', [$date_start,$date_end])
                        ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                        //->where('pengajuan_biaya.status_payment','0')
						->where('pengajuan_biaya.status_spp_2','1')
                        ->where('import_pencapaian_program_detail.status','1');
                        // ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                        // ->Where('izin_h.no_izin', 'like', "%$request->value%")
                        // ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                        // ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
        }

        $data  = $data_transfer->get();
        $count = ($data_transfer->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }
}
