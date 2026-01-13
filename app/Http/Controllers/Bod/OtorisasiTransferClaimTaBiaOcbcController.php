<?php

namespace App\Http\Controllers\Bod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\carbon;

use App\Pengajuan_Biaya;
use App\Pengajuan_Biaya_Detail;
use App\Pengajuan_Upload;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OtorisasiTransferClaimTaBiaOcbcController extends Controller
{
    public function index()
    {
        return view ('bod.otorisasi_transfer_claim_ta_b_ocbc.index');
    }

    public function showDetail($no_urut_pengajuan_biaya)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('perusahaans as perusahaan_tujuan','pengajuan_biaya.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan as perusahaan_tujuan',
                        'pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','ms_pengeluaran.nama_pengeluaran','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.no_urut',
                        'pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.status_validasi_clm')
            ->where('pengajuan_biaya.no_urut', $no_urut_pengajuan_biaya)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
            ->leftjoin('pengajuan_upload','pengajuan_biaya_detail.kode_pengajuan_b','=','pengajuan_upload.kode_pengajuan')
            ->select('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga',
                DB::raw('COUNT(pengajuan_upload.filename) as jml_file'))
            ->where('pengajuan_biaya_detail.no_urut',$no_urut_pengajuan_biaya)
            ->groupBy('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga')
            ->get();

        $approval_upload = DB::table('import_pencapaian_program_upload')
            ->select('import_pencapaian_program_upload.filename')
            ->where('import_pencapaian_program_upload.id_program', $pengajuan_biaya_head->id_program)
            ->get();

        $pengajuan_biaya_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $pengajuan_biaya_head->kode_pengajuan_b)
            ->get();

        $pengajuan_biaya_detail_total = Pengajuan_Biaya_Detail::where('no_urut', $no_urut_pengajuan_biaya)
                                ->get()->sum('tharga');

        return view('bod.otorisasi_transfer_claim_ta_b.detail', compact('pengajuan_biaya_head','pengajuan_biaya_detail','pengajuan_biaya_detail_total','pengajuan_biaya_upload','approval_upload'));
    }

    public function showView(Request $request)
    { 
        $data_list_otorisasi = DB::table('data_transfer')
                ->select('data_transfer.id',
                'data_transfer.tgl_transfer',
                'data_transfer.kode_perusahaan',
                'data_transfer.nama_perusahaan',
                'data_transfer.kode_depo',
                'data_transfer.nama_depo',
                'data_transfer.kode_bank',
                'data_transfer.nama_bank',
                'data_transfer.norek',
                'data_transfer.keterangan',
                'data_transfer.kode_pengajuan_b',
                'data_transfer.kategori',
                'data_transfer.no_surat_program',
                'data_transfer.id_program_ssd',
                'data_transfer.nama_program',
                'data_transfer.kode_perusahaan_program',
                'data_transfer.nama_depo_outlet',
                'data_transfer.kode_outlet',
                'data_transfer.nama_outlet',
                'data_transfer.bank_outlet',
                'data_transfer.norek_outlet',
                'data_transfer.nama_rekening_outlet',
                'data_transfer.reward',
                'data_transfer.reward_tiv',
                'data_transfer.potongan',
                'data_transfer.total',
                'data_transfer.status_otorisasi',
                'data_transfer.id_user_input',
                'pengajuan_biaya.keterangan as keterangan_pengajuan')
                ->join('pengajuan_biaya','data_transfer.kode_pengajuan_b','=','pengajuan_biaya.kode_pengajuan_b')
                ->where('data_transfer.norek', '010 800 031170') //TA Biaya OCBC
                ->where('data_transfer.status_otorisasi', 0)
                ->orderBy('data_transfer.kode_pengajuan_b', 'desc')
                ->orderBy('data_transfer.nama_outlet', 'desc')
                ->get();

        return view('bod.otorisasi_transfer_claim_ta_b_ocbc.view', compact('data_list_otorisasi'));
    }

    public function getData(Request $request)
    {
        $data_otorisasi = DB::table('data_transfer')
                ->select(
                    'data_transfer.kode_pengajuan_b',
                    'data_transfer.no_surat_program',
                    'data_transfer.id_program_ssd',
                    'data_transfer.nama_program', 
                    'pengajuan_biaya.keterangan AS keterangan_biaya',
                    'data_transfer.nama_perusahaan',
                    'data_transfer.kode_bank',
                    'data_transfer.nama_bank',
                    'data_transfer.norek',
                    DB::raw('SUM(data_transfer.reward) AS reward_distributor'),
                    DB::raw('SUM(data_transfer.reward_tiv) AS reward_tiv'),
                    DB::raw('SUM(data_transfer.potongan) AS potongan'),
                    DB::raw('SUM(data_transfer.total) AS total'),
                )
                ->join('pengajuan_biaya', 'data_transfer.kode_pengajuan_b', '=', 'pengajuan_biaya.kode_pengajuan_b')
                ->groupby('data_transfer.kode_pengajuan_b',
                    'data_transfer.no_surat_program',
                    'data_transfer.id_program_ssd',
                    'data_transfer.nama_program', 
                    'pengajuan_biaya.keterangan',
                    'data_transfer.nama_perusahaan',
                    'data_transfer.kode_bank',
                    'data_transfer.nama_bank',
                    'data_transfer.norek');
        if (!isset($request->value)) {
            $data_otorisasi
                        ->where('data_transfer.norek', '010 800 031170'); //TA Biaya OCBC
                        //->where('pengajuan_biaya.kategori', '118')
                        //->where('pengajuan_biaya.status_payment','1')
                        //->where('pengajuan_biaya.status_bod_otorisasi', '0');
                        // ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
        }else{
            $data_otorisasi
                        ->where('data_transfer.norek', '010 800 031170'); //TA Biaya OCBC
                        //->where('pengajuan_biaya.kategori', '118') 
                        //->where('pengajuan_biaya.status_payment','1')
                        //->where('pengajuan_biaya.status_bod_otorisasi', '0');
                        // ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                        // ->Where('izin_h.no_izin', 'like', "%$request->value%")
                        // ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                        // ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
        }

        $data  = $data_otorisasi->get();
        $count = ($data_otorisasi->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function otorisasi(Request $request)
    {
        $status_update = DB::table('data_transfer')
            ->where('data_transfer.id', $request->id)
            ->update([
                    'status_otorisasi' => 1 //otorisasi
                    //'bank' => $request->bank
            ]);

            $output = [
                'msg'  => 'Transaksi berhasil ditambah',
                'res'  => true,
                'type' => 'success'
        ];
        return response()->json($output, 200);
    }

    public function batal(Request $request)
    {
        $status_update = DB::table('data_transfer')
            ->where('data_transfer.id', $request->id)
            ->update([
                    'status_otorisasi' => 2 //Batal
                    //'bank' => $request->bank
            ]);

            $output = [
                'msg'  => 'Transaksi berhasil ditambah',
                'res'  => true,
                'type' => 'success'
        ];
        return response()->json($output, 200);
    }
}
