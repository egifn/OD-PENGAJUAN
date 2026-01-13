<?php

namespace App\Http\Controllers\Snd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perusahaan;
use App\Depo;
use App\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekeningOutletController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $bank = Bank::orderBy('kode_bank', 'ASC')->get();

        return view ('snd.rekening_outlet.index', compact('perusahaan','bank'));
    }
    
    public function ajax_depo_rekening(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
    }

    public function getDataRekening(Request $request)
    {
        $data_rekening = DB::table('rekening_outlet')
                        ->join('depos','rekening_outlet.kode_depo','=','depos.kode_depo')
                        ->join('users','rekening_outlet.id_user_input','=','users.id')
                        ->select('rekening_outlet.id','rekening_outlet.kode_depo','depos.nama_depo','rekening_outlet.kode_toko','rekening_outlet.nama_toko',
                                'rekening_outlet.program','rekening_outlet.nama_pemilik','rekening_outlet.no_rekening','rekening_outlet.nama_rekening',
                                'rekening_outlet.bank_rekening','rekening_outlet.id_user_input','users.name');
        
        if (!isset($request->value)) {

        }else{
            $data_rekening->where('rekening_outlet.nama_toko', 'like', "%$request->value%");
        }

        $data = $data_rekening->get();
        $output = [
            'status' => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function view_excel(Request $request)
    {
        $cari_toko = $request->input('cari_rekening');
        $tombol_excel = $request->input('button_excel');

        if($tombol_excel == 'excel'){
            if($cari_toko != null){
                $data_toko_excel = DB::table('rekening_outlet')
    					->join('depos','rekening_outlet.kode_depo','=','depos.kode_depo')
                        ->select('rekening_outlet.kode_depo','depos.nama_depo','rekening_outlet.kode_toko','rekening_outlet.nama_toko',
                        'rekening_outlet.no_rekening','rekening_outlet.nama_rekening','rekening_outlet.bank_rekening')
                        ->where('rekening_outlet.nama_toko', 'like', "%$cari_toko%")
                        ->get();
            }else{
                $data_toko_excel = DB::table('rekening_outlet')
    					->join('depos','rekening_outlet.kode_depo','=','depos.kode_depo')
                        ->select('rekening_outlet.kode_depo','depos.nama_depo','rekening_outlet.kode_toko','rekening_outlet.nama_toko',
                        'rekening_outlet.no_rekening','rekening_outlet.nama_rekening','rekening_outlet.bank_rekening')
                        ->get();
            }
            return view ('snd.rekening_outlet.view', compact('data_toko_excel'));
        }

    }

    public function store(Request $request)
    {
        DB::table('rekening_outlet')->insert([
            'kode_depo' => $request->kode_depo,
            'kode_toko' => $request->kode_toko,
            'nama_toko' => $request->nama_toko,
            'program' => $request->program,
            'nama_pemilik' => $request->nama_pemilik,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
            'bank_rekening' => $request->bank_rekening,
            'pemilik_vs_norek' => 'ok',
            'keterangan' => $request->keterangan,
        	'id_user_input' => Auth::user()->id
        ]);

        $output = [
            'msg'  => 'Data Berhasil Ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    }

    public function getDataRekeningDetail(Request $request)
    {
        $data = DB::table('rekening_outlet')
                ->join('depos','rekening_outlet.kode_depo','=','depos.kode_depo')
                ->join('users','rekening_outlet.id_user_input','=','users.id')
                ->select('rekening_outlet.id','rekening_outlet.kode_depo','depos.nama_depo','rekening_outlet.kode_toko','rekening_outlet.nama_toko',
                        'rekening_outlet.program','rekening_outlet.nama_pemilik','rekening_outlet.no_rekening','rekening_outlet.nama_rekening',
                        'rekening_outlet.bank_rekening','rekening_outlet.keterangan','rekening_outlet.id_user_input','users.name')
		        ->where('rekening_outlet.id', $request->kode)
                ->first();

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];
        
        return response()->json($output, 200);
    }

    public function update(Request $request)
    {
        DB::table('rekening_outlet')->where('rekening_outlet.id', $request->kode)->update([
            'nama_pemilik' => $request->nama_pemilik,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
            'bank_rekening' => $request->bank_rekening,
            'keterangan' => $request->keterangan,
        ]);

        $output = [
            'message'  => 'Data Berhasil Diubah',
            'status'  => true,
        ];
        return response()->json($output, 200);        
    }
}
