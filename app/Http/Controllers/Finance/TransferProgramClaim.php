<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TransferProgramClaim extends Controller
{
    public function index()
    {
        return view ('finance.transfer.program_claim.index');
    }

    public function showView($no_urut)
    { 
        $data_transfer_head = DB::table('import_pencapaian_program_header')
                            ->select('import_pencapaian_program_header.no_urut_pengajuan')
                            ->where('import_pencapaian_program_header.no_urut_pengajuan', $no_urut)
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
                            'import_pencapaian_program_detail.kode_depo',
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
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.piutang_depo, 0) AS piutang_depo"), 
                            'pengajuan_biaya_claim_piutang.norek_depo', 
                            'banks.nama_bank AS nama_bank_depo', 
                            'rekening_fin_comp.atas_nama_rek as atas_nama_rek_depo',
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.piutang_ng, 0) AS piutang_ng"), 
                            'pengajuan_biaya_claim_piutang.norek_ng',
                            'banks_ng.nama_bank AS nama_bank_ng',
                            'rekening_fin_comp_ng.atas_nama_rek as atas_nama_rek_ng',
                            'import_pencapaian_program_detail.status',
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.status_upload_ng, 0) AS status_upload_ng"),
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.status_upload_depo, 0) AS status_upload_depo"),
                            'pengajuan_biaya.no_urut',
                            'import_pencapaian_program_header.no_urut_pengajuan'
                            )
                            ->distinct()
                            ->join('pengajuan_biaya_claim_piutang','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_claim_piutang.kode_pengajuan_b')
                            ->join('import_pencapaian_program_detail','pengajuan_biaya_claim_piutang.id_toko','=','import_pencapaian_program_detail.kode_outlet')
                            ->join('import_pencapaian_program_header', function ($join) {
                                $join->on('pengajuan_biaya.no_surat_program','=','import_pencapaian_program_header.no_surat')
                                    ->on('pengajuan_biaya.id_program','=','import_pencapaian_program_header.id_program')
                                    ->on('pengajuan_biaya.kode_perusahaan_tujuan','=','import_pencapaian_program_header.kode_perusahaan')
                                    ->on('pengajuan_biaya.no_urut','=','import_pencapaian_program_header.no_urut_pengajuan');
                            }) 
                            ->join('claim_surat_program', function ($join) {
                                $join->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program')
                                    ->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat');
                            })
                            ->leftJoin('rekening_outlet','import_pencapaian_program_detail.kode_outlet','=','rekening_outlet.kode_toko')
                            ->leftJoin('rekening_fin_comp','pengajuan_biaya_claim_piutang.norek_depo','=','rekening_fin_comp.norek')
                            ->leftJoin('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                            ->leftJoin('rekening_fin_comp AS rekening_fin_comp_ng','pengajuan_biaya_claim_piutang.norek_ng','=','rekening_fin_comp_ng.norek')
                            ->leftJoin('banks AS banks_ng','rekening_fin_comp_ng.kode_bank','=','banks_ng.kode_bank')
                            ->whereIn('pengajuan_biaya.kategori', ['43','118'])

                            ->whereIn('import_pencapaian_program_detail.status', ['0','2','3'])
                            
                            ->where('pengajuan_biaya.no_urut', $no_urut)
                            ->where('import_pencapaian_program_header.no_urut_pengajuan', $no_urut)
                            ->where('import_pencapaian_program_detail.no_urut_pengajuan', $no_urut)
                            
							->orderBy('import_pencapaian_program_detail.nama_depo', 'asc')
							->orderBy('import_pencapaian_program_detail.id', 'asc')
                            ->get();

        return view('finance.transfer.program_claim.view', compact('data_list_transfer','data_transfer_head'));
    }

    public function getData(Request $request)
    {
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
                ->join('claim_surat_program', function ($join) {
                    $join->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program')
                        ->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat');
                })
                ->join('import_pencapaian_program_detail', function ($join) {
                    $join->on('import_pencapaian_program_header.no_surat', '=', 'import_pencapaian_program_detail.no_surat')
                        ->on('import_pencapaian_program_header.kode_perusahaan', '=', 'import_pencapaian_program_detail.kode_perusahaan');
                })
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
                        ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                        ->where('pengajuan_biaya.status_payment','0')
						->where('pengajuan_biaya.status_spp_2','1')
                        ->where('import_pencapaian_program_detail.status','0');
						
                        // ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
        }else{
            $data_transfer
                        ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                        ->where('pengajuan_biaya.status_payment','0')
						->where('pengajuan_biaya.status_spp_2','1')
                        ->where('import_pencapaian_program_detail.status','0');
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
	
	public function transfer(Request $request)
    {
        DB::table('data_transfer')->insert([
            'tgl_transfer' => Carbon::now()->format('Y-m-d'),
            'kode_perusahaan' => $request->kode_perusahaan_head,
            'nama_perusahaan' => $request->nama_perusahaan_head,
            'kode_depo' => $request->kode_depo_head,
            'nama_depo' => $request->nama_depo_head,
            'kode_bank' => $request->kode_bank_head,
            'nama_bank' => $request->nama_bank_head,
            'norek' => $request->norek_head,
            'keterangan' => $request->radio_head,
            'kode_pengajuan_b' => $request->kode_pengajuan_b,
            'kategori' => $request->kategori,
            'no_surat_program' => $request->no_surat_program,
            'id_program_ssd' => $request->id_program_ssd,
            'nama_program' => $request->nama_program,
            'kode_perusahaan_program' => $request->kode_perusahaan_detail,
            'nama_depo_outlet' => $request->nama_depo,
            'kode_outlet' => $request->kode_outlet,
            'nama_outlet' => $request->nama_outlet,
            'bank_outlet' => $request->bank_rekening,
            'norek_outlet' => $request->no_rekening,
            'nama_rekening_outlet' => $request->nama_rekening,
            'reward' => $request->reward,
            'reward_tiv' => $request->reward_tiv,
            'potongan' => $request->potongan,
            'total' => $request->total,
            'id_user_input' => Auth::user()->id
        ]);

        $getRow = DB::table('import_pencapaian_program_detail')
                ->select('import_pencapaian_program_detail.no_surat')
                ->where('import_pencapaian_program_detail.no_urut_pengajuan', $request->no_urut)
                ->where('import_pencapaian_program_detail.status', 0);
        $rowCount = $getRow->count();
        if ($rowCount === 1) {
            $status_update = DB::table('pengajuan_biaya')
                ->where('pengajuan_biaya.kode_pengajuan_b', $request->kode_pengajuan_b)
                ->update([
                        'pengajuan_biaya.status_payment' => 1
                ]);
        }

        $status_update = DB::table('import_pencapaian_program_detail')
            ->where('import_pencapaian_program_detail.no_surat', $request->no_surat_program)
            ->where('import_pencapaian_program_detail.kode_outlet', $request->kode_outlet)
            ->where('import_pencapaian_program_detail.no_urut_pengajuan', $request->no_urut)
            ->update([
                    'status' => 1
            ]);

        $output = [
                'msg'  => 'Transaksi berhasil ditambah',
                'res'  => true,
                'type' => 'success'
        ];
        return response()->json($output, 200);
    }

    public function transfer_ng(Request $request)
    {
        DB::table('data_transfer')->insert([
            'tgl_transfer' => Carbon::now()->format('Y-m-d'),
            'kode_perusahaan' => $request->kode_perusahaan_head,
            'nama_perusahaan' => $request->nama_perusahaan_head,
            'kode_depo' => $request->kode_depo_head,
            'nama_depo' => $request->nama_depo_head,
            'kode_bank' => $request->kode_bank_head,
            'nama_bank' => $request->nama_bank_head,
            'norek' => $request->norek_head,
            'keterangan' => $request->radio_head,
            'kode_pengajuan_b' => $request->kode_pengajuan_b,
            'kategori' => $request->kategori,
            'no_surat_program' => $request->no_surat_program,
            'id_program_ssd' => $request->id_program_ssd,
            'nama_program' => $request->nama_program,
            'kode_perusahaan_program' => $request->kode_perusahaan_detail,
            'nama_depo_outlet' => $request->nama_depo,
            'kode_outlet' => $request->kode_outlet,
            'nama_outlet' => $request->nama_outlet,
            'bank_outlet' => $request->bank_ng,
            'norek_outlet' => $request->norek_ng,
            'nama_rekening_outlet' => $request->atas_nama_rek_ng,
            'reward' => $request->reward,
            'reward_tiv' => $request->reward_tiv,
            'potongan' => $request->potongan,
            'total' => $request->ng_piutang,
            'id_user_input' => Auth::user()->id
        ]);

        $status_update_ng = DB::table('import_pencapaian_program_detail')
            ->where('import_pencapaian_program_detail.no_surat', $request->no_surat_program)
            ->where('import_pencapaian_program_detail.kode_outlet', $request->kode_outlet)
            ->where('import_pencapaian_program_detail.no_urut_pengajuan', $request->no_urut)
            ->update([
                    'status' => 2
            ]);
            
        $status_update = DB::table('pengajuan_biaya_claim_piutang')
            ->where('pengajuan_biaya_claim_piutang.kode_pengajuan_b', $request->kode_pengajuan_b)
            ->where('pengajuan_biaya_claim_piutang.id_toko', $request->kode_outlet)
            ->update([
                    'status_upload_ng' => 1
            ]);

        $output = [
                'msg'  => 'Transaksi berhasil ditambah',
                'res'  => true,
                'type' => 'success'
        ];
        return response()->json($output, 200);

    }

    public function transfer_depo(Request $request)
    {
        DB::table('data_transfer')->insert([
            'tgl_transfer' => Carbon::now()->format('Y-m-d'),
            'kode_perusahaan' => $request->kode_perusahaan_head,
            'nama_perusahaan' => $request->nama_perusahaan_head,
            'kode_depo' => $request->kode_depo_head,
            'nama_depo' => $request->nama_depo_head,
            'kode_bank' => $request->kode_bank_head,
            'nama_bank' => $request->nama_bank_head,
            'norek' => $request->norek_head,
            'keterangan' => $request->radio_head,
            'kode_pengajuan_b' => $request->kode_pengajuan_b,
            'kategori' => $request->kategori,
            'no_surat_program' => $request->no_surat_program,
            'id_program_ssd' => $request->id_program_ssd,
            'nama_program' => $request->nama_program,
            'kode_perusahaan_program' => $request->kode_perusahaan_detail,
            'nama_depo_outlet' => $request->nama_depo,
            'kode_outlet' => $request->kode_outlet,
            'nama_outlet' => $request->nama_outlet,
            'bank_outlet' => $request->nama_bank_depo,
            'norek_outlet' => $request->norek_depo,
            'nama_rekening_outlet' => $request->atas_nama_rek_depo,
            'reward' => $request->reward,
            'reward_tiv' => $request->reward_tiv,
            'potongan' => $request->potongan,
            'total' => $request->piutang_depo,
            'id_user_input' => Auth::user()->id
        ]);

        $status_update_ng = DB::table('import_pencapaian_program_detail')
            ->where('import_pencapaian_program_detail.no_surat', $request->no_surat_program)
            ->where('import_pencapaian_program_detail.kode_outlet', $request->kode_outlet)
            ->where('import_pencapaian_program_detail.no_urut_pengajuan', $request->no_urut)
            ->update([
                    'status' => 3
            ]);

        $status_update = DB::table('pengajuan_biaya_claim_piutang')
            ->where('pengajuan_biaya_claim_piutang.kode_pengajuan_b', $request->kode_pengajuan_b)
            ->where('pengajuan_biaya_claim_piutang.id_toko', $request->kode_outlet)
            ->update([
                    'status_upload_depo' => 1
            ]);

        $output = [
                'msg'  => 'Transaksi berhasil ditambah',
                'res'  => true,
                'type' => 'success'
        ];
        return response()->json($output, 200);
    }
	
    public function transfer_all(Request $request)
    {
        DB::table('data_transfer')->insert([
            'tgl_transfer' => Carbon::now()->format('Y-m-d'),
            'kode_perusahaan' => $request->kode_perusahaan_head,
            'nama_perusahaan' => $request->nama_perusahaan_head,
            'kode_depo' => $request->kode_depo_head,
            'nama_depo' => $request->nama_depo_head,
            'kode_bank' => $request->kode_bank_head,
            'nama_bank' => $request->nama_bank_head,
            'norek' => $request->norek_head,
            'keterangan' => $request->radio_head,
            'kode_pengajuan_b' => $request->kode_pengajuan_b,
            'kategori' => $request->kategori,
            'no_surat_program' => $request->no_surat_program,
            'id_program_ssd' => $request->id_program_ssd,
            'nama_program' => $request->nama_program,
            'kode_perusahaan_program' => $request->kode_perusahaan_detail,
            'nama_depo_outlet' => $request->nama_depo,
            'kode_outlet' => $request->kode_outlet,
            'nama_outlet' => $request->nama_outlet,
            'bank_outlet' => $request->bank_rekening,
            'norek_outlet' => $request->no_rekening,
            'nama_rekening_outlet' => $request->nama_rekening,
            'reward' => $request->reward,
            'reward_tiv' => $request->reward_tiv,
            'potongan' => $request->potongan,
            'total' => $request->total,
            'id_user_input' => Auth::user()->id
        ]);

        $status_update = DB::table('import_pencapaian_program_detail')
            ->where('import_pencapaian_program_detail.no_surat', $request->no_surat_program)
            ->where('import_pencapaian_program_detail.tgl_import', $request->tgl_import)
            ->where('import_pencapaian_program_detail.no_urut_pengajuan', $request->no_urut)
            ->update([
                    'status' => 1
            ]);

        $output = [
                'msg'  => 'Transaksi berhasil ditambah',
                'res'  => true,
                'type' => 'success'
        ];
        return response()->json($output, 200);
    }

    public function excel(Request $request, $no_urut)
	{
		
            $data_transfer_head = DB::table('import_pencapaian_program_header')
                            ->select('import_pencapaian_program_header.no_urut_pengajuan')
                            ->where('import_pencapaian_program_header.no_urut_pengajuan', $request->no_urut)
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
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.piutang_depo, 0) AS piutang_depo"), 
                            'pengajuan_biaya_claim_piutang.norek_depo', 
                            'banks.nama_bank AS nama_bank_depo', 
                            'rekening_fin_comp.atas_nama_rek as atas_nama_rek_depo',
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.piutang_ng, 0) AS piutang_ng"), 
                            'pengajuan_biaya_claim_piutang.norek_ng',
                            'banks_ng.nama_bank AS nama_bank_ng',
                            'rekening_fin_comp_ng.atas_nama_rek as atas_nama_rek_ng',
                            'import_pencapaian_program_detail.status',
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.status_upload_ng, 0) AS status_upload_ng"),
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.status_upload_depo, 0) AS status_upload_depo"),
                            'pengajuan_biaya.no_urut',
                            'import_pencapaian_program_header.no_urut_pengajuan'
                            )
                            ->distinct()
                            ->join('pengajuan_biaya_claim_piutang','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_claim_piutang.kode_pengajuan_b')
                            ->join('import_pencapaian_program_detail','pengajuan_biaya_claim_piutang.id_toko','=','import_pencapaian_program_detail.kode_outlet')
                            ->join('import_pencapaian_program_header', function ($join) {
                                $join->on('pengajuan_biaya.no_surat_program','=','import_pencapaian_program_header.no_surat')
                                    ->on('pengajuan_biaya.id_program','=','import_pencapaian_program_header.id_program')
                                    ->on('pengajuan_biaya.kode_perusahaan_tujuan','=','import_pencapaian_program_header.kode_perusahaan')
                                    ->on('pengajuan_biaya.no_urut','=','import_pencapaian_program_header.no_urut_pengajuan');
                            }) 
                            ->join('claim_surat_program', function ($join) {
                                $join->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program')
                                    ->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat');
                            })
                            ->leftJoin('rekening_outlet','import_pencapaian_program_detail.kode_outlet','=','rekening_outlet.kode_toko')
                            ->leftJoin('rekening_fin_comp','pengajuan_biaya_claim_piutang.norek_depo','=','rekening_fin_comp.norek')
                            ->leftJoin('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                            ->leftJoin('rekening_fin_comp AS rekening_fin_comp_ng','pengajuan_biaya_claim_piutang.norek_ng','=','rekening_fin_comp_ng.norek')
                            ->leftJoin('banks AS banks_ng','rekening_fin_comp_ng.kode_bank','=','banks_ng.kode_bank')
                            ->whereIn('pengajuan_biaya.kategori', ['43','118'])
                            ->where('import_pencapaian_program_detail.status', 0)
                            ->where('pengajuan_biaya.no_urut', $request->no_urut)
                            ->where('import_pencapaian_program_header.no_urut_pengajuan', $request->no_urut)
                            ->where('import_pencapaian_program_detail.no_urut_pengajuan', $request->no_urut)
                            //->orderBy('import_pencapaian_program_detail.nama_outlet', 'ASC')
                            ->orderBy('import_pencapaian_program_detail.nama_depo', 'asc')
							->orderBy('import_pencapaian_program_detail.id', 'asc')
                            ->get();


            return view ('finance.transfer.program_claim.view_e', compact('data_list_transfer','data_transfer_head'));
    }

    public function excel_bulk(Request $request, $no_urut)
    {
        $option = $request->input('radio');
        $nama_perusahaan = $request->input('nama_perusahaan');
        $norek = $request->input('norek');
		$atas_nama_perusahaan = $request->input('atas_nama');
        $cara_bayar = $request->input('cara_bayar');
        $tanggal = $request->input('tanggal');
        $remarks = $request->input('remarks');

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
                            'bank_bulk_transfer.llg_clearing_id',
                            'bank_bulk_transfer.bene_bank_id',
                            'bank_bulk_transfer.member_code',
                            'bank_bulk_transfer.bene_bank_name',
                            'bank_bulk_transfer.bene_bank_branch_name',
                            'bank_bulk_transfer.bene_bank_country_code',
                            'import_pencapaian_program_detail.reward', 
                            'import_pencapaian_program_detail.reward_tiv', 
                            'import_pencapaian_program_detail.total_reward', 
                            DB::raw("CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' WHEN rekening_outlet.bank_rekening = '#N/A' THEN '0' ELSE '2900' END AS potongan"),
                            DB::raw("import_pencapaian_program_detail.total_reward - (CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' WHEN rekening_outlet.bank_rekening = '#N/A' THEN '0' ELSE '2900' END) AS total"),
                            'import_pencapaian_program_detail.no_urut',
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.piutang_depo, 0) AS piutang_depo"), 
                            'pengajuan_biaya_claim_piutang.norek_depo', 
                            'banks.nama_bank AS nama_bank_depo', 
                            'rekening_fin_comp.atas_nama_rek as atas_nama_rek_depo',
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.piutang_ng, 0) AS piutang_ng"), 
                            'pengajuan_biaya_claim_piutang.norek_ng',
                            'banks_ng.nama_bank AS nama_bank_ng',
                            'rekening_fin_comp_ng.atas_nama_rek as atas_nama_rek_ng',
                            'import_pencapaian_program_detail.status',
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.status_upload_ng, 0) AS status_upload_ng"),
                            DB::raw("IFNULL(pengajuan_biaya_claim_piutang.status_upload_depo, 0) AS status_upload_depo"),
                            'pengajuan_biaya.no_urut',
                            'import_pencapaian_program_header.no_urut_pengajuan'
                            )
                            ->distinct()
                            ->join('pengajuan_biaya_claim_piutang','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_claim_piutang.kode_pengajuan_b')
                            ->join('import_pencapaian_program_detail','pengajuan_biaya_claim_piutang.id_toko','=','import_pencapaian_program_detail.kode_outlet')
                            ->join('import_pencapaian_program_header', function ($join) {
                                $join->on('pengajuan_biaya.no_surat_program','=','import_pencapaian_program_header.no_surat')
                                    ->on('pengajuan_biaya.id_program','=','import_pencapaian_program_header.id_program')
                                    ->on('pengajuan_biaya.kode_perusahaan_tujuan','=','import_pencapaian_program_header.kode_perusahaan')
                                    ->on('pengajuan_biaya.no_urut','=','import_pencapaian_program_header.no_urut_pengajuan');
                            }) 
                            ->join('claim_surat_program', function ($join) {
                                $join->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program')
                                    ->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat');
                            })
                            ->leftJoin('rekening_outlet','import_pencapaian_program_detail.kode_outlet','=','rekening_outlet.kode_toko')
                            ->leftJoin('rekening_fin_comp','pengajuan_biaya_claim_piutang.norek_depo','=','rekening_fin_comp.norek')
                            ->leftJoin('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                            ->leftJoin('rekening_fin_comp AS rekening_fin_comp_ng','pengajuan_biaya_claim_piutang.norek_ng','=','rekening_fin_comp_ng.norek')
                            ->leftJoin('banks AS banks_ng','rekening_fin_comp_ng.kode_bank','=','banks_ng.kode_bank')
                            ->leftJoin('bank_bulk_transfer','rekening_outlet.bank_rekening','bank_bulk_transfer.id_bank')
                            ->whereIn('pengajuan_biaya.kategori', ['43','118'])

                            ->whereIn('import_pencapaian_program_detail.status', ['0','2','3'])
                            
                            ->where('pengajuan_biaya.no_urut', $request->no_urut)
                            ->where('import_pencapaian_program_header.no_urut_pengajuan', $request->no_urut)
                            ->where('import_pencapaian_program_detail.no_urut_pengajuan', $request->no_urut)
                            //->orderBy('import_pencapaian_program_detail.nama_outlet', 'ASC')
                            ->orderBy('import_pencapaian_program_detail.nama_depo', 'asc')
							->orderBy('import_pencapaian_program_detail.id', 'asc')
                            ->get();

        if($option == 'transfer'){
            return view ('finance.transfer.program_claim.view_e', compact('data_list_transfer'));
        }elseif($option == 'bulk'){
            return view('finance.transfer.program_claim.view_e_bulk', compact('data_list_transfer','nama_perusahaan','atas_nama_perusahaan','norek','cara_bayar','tanggal','remarks'));           
        }
    }

}
