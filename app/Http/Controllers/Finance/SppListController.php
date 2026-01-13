<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pengajuan_Biaya_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class SppListController extends Controller
{
    public function index()
    {
        return view ('finance.spp_list.index');
    }

    public function getDataSppTerima(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_spp_terima = DB::table('spp_penerimaan_finance')
                            ->join('users','spp_penerimaan_finance.id_user_input','=','users.id')
                            ->select('spp_penerimaan_finance.kode_spp_penerimaan','spp_penerimaan_finance.tgl_penerimaan','spp_penerimaan_finance.cara_bayar',
                                    'spp_penerimaan_finance.keterangan','users.name')
                            ->WhereBetween('spp_penerimaan_finance.tgl_penerimaan',[$date_start,$date_end]);

        $data = $data_spp_terima->get();
        $output = [
            'status'  => true,
            'message' => 'success',
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

        $data_spp_terima = DB::table('spp_penerimaan_finance')
                            ->join('users','spp_penerimaan_finance.id_user_input','=','users.id')
                            ->select('spp_penerimaan_finance.kode_spp_penerimaan','spp_penerimaan_finance.tgl_penerimaan','spp_penerimaan_finance.cara_bayar',
                                    'spp_penerimaan_finance.keterangan','users.name')
                            ->WhereBetween('spp_penerimaan_finance.tgl_penerimaan', [$date_start,$date_end]);

        $data = $data_spp_terima->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];
        return response()->json($output, 200);
    }

    public function getDataDetail(Request $request)
    {
        $data_detail_terima = DB::table('spp_penerimaan_finance')
                            ->join('spp_penerimaan_finance_detail','spp_penerimaan_finance.kode_spp_penerimaan','=','spp_penerimaan_finance_detail.kode_spp_penerimaan')
                            ->join('vendors','spp_penerimaan_finance_detail.kode_vendor','=','vendors.kode_vendor')
                            ->join('users','spp_penerimaan_finance.id_user_input','=','users.id')
                            ->select('spp_penerimaan_finance.kode_spp_penerimaan','spp_penerimaan_finance.tgl_penerimaan','spp_penerimaan_finance.cara_bayar','spp_penerimaan_finance.keterangan',
                                    'spp_penerimaan_finance_detail.no_spp','spp_penerimaan_finance_detail.tgl_spp','spp_penerimaan_finance_detail.tgl_jatuh_tempo',
                                    'spp_penerimaan_finance_detail.keterangan_spp','spp_penerimaan_finance_detail.kode_perusahaan','spp_penerimaan_finance_detail.jumlah',
                                    'spp_penerimaan_finance_detail.kode_vendor','vendors.nama_vendor','users.name')
                            ->where('spp_penerimaan_finance.kode_spp_penerimaan', $request->kode_penerimaan_spp)
                            ->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data_detail_terima
        ];
                    
        return response()->json($output, 200);
    }

    public function getDataLampiran(Request $request)
    {
        $data_lampiran = DB::table('pengajuan_biaya')
                        ->leftJoin('pengajuan_upload','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_upload.kode_pengajuan')
                        ->leftJoin('import_pencapaian_program_header','pengajuan_biaya.no_urut','=','import_pencapaian_program_header.no_urut_pengajuan')
                        ->leftJoin('import_pencapaian_program_upload','import_pencapaian_program_header.no_urut','=','import_pencapaian_program_upload.no_urut')
                        ->leftJoin('claim_surat_program','pengajuan_biaya.no_surat_program','=','claim_surat_program.no_surat')
                        ->leftJoin('claim_upload_surat_program','claim_surat_program.no_surat','=','claim_upload_surat_program.no_surat')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_upload.filename',
                                'import_pencapaian_program_upload.filename AS filename_pengajuan_claim_ssd',
                                'claim_upload_surat_program.filename_upload')
                        ->where('pengajuan_biaya.no_urut', $request->no_urut_pengajuan)
                        ->orderBy('pengajuan_biaya.kode_pengajuan_b', 'asc') 
                        ->orderBy('pengajuan_upload.filename', 'asc')      
                        ->orderBy('import_pencapaian_program_upload.filename', 'asc')
                        ->orderByRaw('claim_upload_surat_program.filename_upload IS NULL, claim_upload_surat_program.filename_upload ASC')
                        ->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data_lampiran
        ];

        return response()->json($output, 200);
    }

    public function getDataLampiranManual(Request $request)
    {
        $data_lampiran_manual = DB::table('spp')
                                ->join('pengajuan_upload','spp.no_kontrabon','=','pengajuan_upload.kode_pengajuan')
                                ->select('SPP.no_kontrabon', 'pengajuan_upload.filename')
                                ->where('SPP.no_urut', $request->no_urut)
                                ->get();

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data_lampiran_manual
        ];

        return response()->json($output, 200);

    }
    

    public function getDataSpp(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_spp = DB::table('spp')
                    ->leftjoin('pengajuan_biaya','spp.no_kontrabon','=','pengajuan_biaya.kode_pengajuan_b')
                    ->select('spp.no_urut','spp.no_spp','spp.tgl_spp','pengajuan_biaya.no_urut as no_urut_pengajuan','no_kontrabon','spp.ditujukan','spp.kode_vendor','spp.for','spp.jumlah',
                    'spp.jatuh_tempo','spp.keterangan','spp.jenis','spp.status',
                    'pengajuan_biaya.kode_perusahaan_tujuan','spp.kode_approved_spp_1',
                    'pengajuan_biaya.kategori'
                    )
                    // ->WhereBetween('spp.tgl_spp',[$date_start,$date_end])
                    ->Where('spp.status',0)
                    ->Where('spp.status_spp_1',1)
                    ->Where('spp.status_spp_2',1);

        $data = $data_spp->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];
        return response()->json($output, 200);
    }

    public function create(Request $request)
    {
        return view('finance.spp_list.create');
    }

    public function store(Request $request)
    {

        $cara_bayar = $request->cara_bayar;
        $keterangan_head =  $request->keterangan_head;

        $chk = $request->chk;
        $no_spp = $request->no_spp;
        $tgl_spp = $request->tgl_spp;
        $tgl_jt = $request->tgl_jt;
        $keterangan = $request->keterangan;
        $perusahaan_tujuan = $request->perusahaan_tujuan;
        $ttl_rupiah = str_replace(",", "", $request->ttl_rupiah);
        $kode_vendor = $request->kode_vendor;

        $date = (date('Ym'));
        $date_1 = (date('Ymd'));
        $getRow = DB::table('spp_penerimaan_finance')->select(DB::raw('MAX(RIGHT(kode_spp_penerimaan,6)) as NoUrut'))
                                        ->where('kode_spp_penerimaan', 'like', "%".$date."%");
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $no_terima = "SPP".$date_1."00000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $no_terima = "SPP".$date_1."0000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $no_terima = "SPP".$date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $no_terima = "SPP".$date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $no_terima = "SPP".$date_1."0".''.($rowCount + 1);
            } else {
                    $no_terima = "SPP".$date_1.($rowCount + 1);
            }
        }else{
            $no_terima = "SPP".$date_1.sprintf("%06s", 1);
        }

        DB::table('spp_penerimaan_finance')->insert([
            'kode_spp_penerimaan' => $no_terima,
            'tgl_penerimaan' => Carbon::now()->format('Y-m-d'),
            'cara_bayar' => $cara_bayar,
            'keterangan' => $keterangan_head,
            'id_user_input' => Auth::user()->id,
        ]);

        for ($i=0; $i < count((array)$no_spp); $i++) {
            if($chk[$i] == 1){
                DB::table('spp_penerimaan_finance_detail')->insert([
                    'kode_spp_penerimaan' => $no_terima,
                    'no_spp' => $no_spp[$i],
                    'tgl_spp' => Carbon::createFromFormat('d-M-Y', $tgl_spp[$i])->format('Y-m-d'),
                    'tgl_jatuh_tempo' => Carbon::createFromFormat('d-M-Y', $tgl_jt[$i])->format('Y-m-d'),
                    'keterangan_spp' => $keterangan[$i],
                    'kode_perusahaan' => $perusahaan_tujuan[$i],
                    'jumlah' => $ttl_rupiah[$i],
                    'kode_vendor' => $kode_vendor[$i],
                ]);
            }
        }
		
		for ($u=0; $u < count((array)$no_spp); $u++){
            if($chk[$i] == 1){
                $data_update = DB::table('spp')
                    ->select('spp.status')
                    ->where('spp.no_spp', $no_spp[$u])
                    ->update([
                        'status' => 9
                    ]);
            }
        }

        $output = [
            'msg'  => 'Transaksi baru berhasil ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);


    }

    public function pdf_spp($no_urut)
    {   
        $tgl_cetak = Carbon::now()->format('d/m/y'); //h:i a

        $spp_pdf = DB::table('spp')->join('users','spp.id_user_input','=','users.id')
                        ->leftjoin('users AS ka_biaya','spp.id_user_approval_spp_1','=','ka_biaya.id')
                        ->leftjoin('users AS ka_acc','spp.id_user_approval_spp_2','=','ka_acc.id')
                        ->leftjoin('pengajuan_biaya','spp.no_spp','=','pengajuan_biaya.no_spp')
                        ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                        ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
						->select('pengajuan_biaya.no_urut','spp.no_spp','spp.tgl_spp','spp.no_kontrabon','spp.kode_pembelian',
						'spp.ditujukan','spp.for','spp.jumlah','spp.jatuh_tempo','spp.keterangan','spp.jenis',
						'spp.id_user_input','spp.kode_user_input_spp','spp.kode_depo','spp.sumber_dana','spp.pajak_masukan','spp.kode_vendor',
						'banks.nama_bank','spp.pembayaran','rekening_fin.atas_nama','spp.metode_pembayaran','spp.yang_mengajukan',
						'spp.kode_approved_spp_1','spp.kode_approved_spp_2','users.name','ka_biaya.name AS ka_biaya','ka_acc.name AS ka_acc')
                        ->where('spp.no_urut', $no_urut)
                        ->orderBy('spp.no_urut', 'ASC')
                        ->first();
        $sd_1 = DB::table('spp_sumber_dana')->where('kode',1)->first();
        $sd_2 = DB::table('spp_sumber_dana')->where('kode',2)->first();
        $sd_3 = DB::table('spp_sumber_dana')->where('kode',3)->first();
        $sd_4 = DB::table('spp_sumber_dana')->where('kode',4)->first();
        $sd_5 = DB::table('spp_sumber_dana')->where('kode',5)->first();

        // $pdf = PDF::loadview('finance.spp.pdf', compact('spp_pdf','tgl_cetak','sd_1','sd_2','sd_3','sd_4','sd_5'));
        $pdf = PDF::loadview('pengajuan.pengajuan_tiv.pdf_spp', compact('spp_pdf','tgl_cetak','sd_1','sd_2','sd_3','sd_4','sd_5'));
        return $pdf->stream();
    }

    public function pdf_pengajuan($no_urut_pengajuan)
    {
        $pengajuan_tiv_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->where('pengajuan_biaya.no_urut', $no_urut_pengajuan)->first();

        //$pengajuan_tiv_detail = DB::table('pengajuan_biaya_detail')->where('pengajuan_biaya_detail.no_urut',$no_urut)->get();

        $data_view_program_all = DB::select("SELECT DISTINCT
            import_pencapaian_program_header.no_surat,
            claim_surat_program.id_program,
            import_pencapaian_program_detail.kode_perusahaan AS perusahaan,
            import_pencapaian_program_detail.nama_depo AS dist_depo,
            import_pencapaian_program_detail.cluster,
            import_pencapaian_program_detail.kode_outlet AS customer_id,
            import_pencapaian_program_detail.nama_outlet AS customer_name,
            rekening_outlet.no_rekening AS no_rek,
            rekening_outlet.bank_rekening AS bank,
            rekening_outlet.nama_rekening AS nama_rekening,
            import_pencapaian_program_detail.reward,
            import_pencapaian_program_detail.reward_tiv,
            CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END AS potongan,
            import_pencapaian_program_detail.reward + import_pencapaian_program_detail.reward_tiv - (CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END) AS ditransfer,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_depo,0) as piutang_depo,
            pengajuan_biaya_claim_piutang.norek_depo,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_ng,0) as piutang_ng,
            pengajuan_biaya_claim_piutang.norek_ng
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_surat = import_pencapaian_program_detail.no_surat
            AND import_pencapaian_program_header.tgl_import = import_pencapaian_program_detail.tgl_import
            INNER JOIN claim_surat_program ON import_pencapaian_program_header.no_surat = claim_surat_program.no_surat
            AND import_pencapaian_program_header.id_program = claim_surat_program.id_program
            LEFT JOIN rekening_outlet ON import_pencapaian_program_detail.kode_outlet = rekening_outlet.kode_toko
            LEFT JOIN pengajuan_biaya_claim_piutang ON import_pencapaian_program_detail.no_surat = pengajuan_biaya_claim_piutang.no_surat
            AND import_pencapaian_program_detail.kode_outlet = pengajuan_biaya_claim_piutang.id_toko
            AND import_pencapaian_program_detail.no_urut_pengajuan = pengajuan_biaya_claim_piutang.no_urut_pengajuan
            WHERE import_pencapaian_program_detail.no_urut_pengajuan = '$no_urut_pengajuan'
            ");
        

        /*$total_jml = Pengajuan_Biaya_Kwb_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');*/

        $total_jml = DB::table('pengajuan_biaya_detail')
                        ->select(DB::raw('SUM(pengajuan_biaya_detail.qty) as qty'),
                                 DB::raw('SUM(pengajuan_biaya_detail.harga) as harga'),
                                 DB::raw('SUM(pengajuan_biaya_detail.jml_harga) as jml_harga'),
                                 DB::raw('SUM(pengajuan_biaya_detail.potongan) as potongan'),
                                 DB::raw('SUM(pengajuan_biaya_detail.harga - pengajuan_biaya_detail.potongan) as ditransfer'))
                        ->where('pengajuan_biaya_detail.no_urut', $no_urut_pengajuan)
                        ->first();

        $pdf = PDF::loadview('pengajuan.pengajuan_tiv.pdf', compact('pengajuan_tiv_head','data_view_program_all','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function pdf_pengajuan_biaya($no_urut_pengajuan)
    {
        if (is_null($no_urut_pengajuan)) {
            dd($no_urut_pengajuan);
            return response()->json([
                'message' => 'Pengajuan ini dibuat manual'
            ], 400); // status 400 = Bad Request (opsional)
        }

        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->leftjoin('users','pengajuan_biaya.id_user_input','=','users.id')
            ->leftjoin('users as kabiayadepo','pengajuan_biaya.id_user_approval_biaya','kabiayadepo.id')
            ->leftjoin('users as kabiayaho','pengajuan_biaya.id_user_approval_biaya_pusat','kabiayaho.id')
            ->leftjoin('users as kaopsdepo','pengajuan_biaya.id_user_approval_atasan','kaopsdepo.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            ->leftjoin('users as picho','pengajuan_biaya_detail.id_user_detail_acc','=','picho.id')
            ->select('ms_pengeluaran.sifat','pengajuan_biaya.kode_pengajuan_b','users.name','divisi.nama_divisi',
                    'kabiayadepo.name as atasan','depos.nama_depo','pengajuan_biaya.tgl_pengajuan_b','ms_pengeluaran.keterangan',
                    'pengajuan_biaya.kode_app_biaya',
                    'kabiayaho.name as kabiayaho','pengajuan_biaya.tgl_approval_biaya_pusat','pengajuan_biaya.kode_app_biaya_pusat',
                    'kaopsdepo.name as kaopsdepo','pengajuan_biaya.tgl_approval_atasan','pengajuan_biaya.kode_app_atasan',
                    'picho.name as picho','pengajuan_biaya_detail.tgl_approval_detail_acc'
                    )
            ->where('pengajuan_biaya.no_urut', $no_urut_pengajuan)
            ->groupby('ms_pengeluaran.sifat','pengajuan_biaya.kode_pengajuan_b','users.name','divisi.nama_divisi',
                    'kabiayadepo.name','depos.nama_depo','pengajuan_biaya.tgl_pengajuan_b','ms_pengeluaran.keterangan',
                    'pengajuan_biaya.kode_app_biaya',
                    'kabiayaho.name','pengajuan_biaya.tgl_approval_biaya_pusat','pengajuan_biaya.kode_app_biaya_pusat',
                    'kaopsdepo.name','pengajuan_biaya.tgl_approval_atasan','pengajuan_biaya.kode_app_atasan',
                    'picho.name','pengajuan_biaya_detail.tgl_approval_detail_acc')
            ->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
            ->where('pengajuan_biaya_detail.no_urut',$no_urut_pengajuan)
            ->orderBy('pengajuan_biaya_detail.no_description_detail', 'ASC')
            ->get();

        $total_jml = Pengajuan_Biaya_Detail::where('no_urut', $no_urut_pengajuan)
                                ->where('status_detail', 1)
                                ->get()->sum('tharga');
                                

        $pdf = PDF::loadview('pengajuan.pengajuan_biaya.pdf', compact('pengajuan_biaya_head','pengajuan_biaya_detail','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
