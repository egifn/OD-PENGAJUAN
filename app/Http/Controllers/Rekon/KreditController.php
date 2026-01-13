<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\MutasiRekening;
use App\Rekening;   
use App\Perusahaan;
use App\Depo;
use App\Virtualaccount;
use App\CatatanNonTunaiKreditPerusahaan;
use App\CatatanNonTunaiKreditBank;
use App\CatatanRekening;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KreditController extends Controller
{
    public function ajax_depo_dms(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaandms_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
    }

    public function ajax_depo_bank(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaanbank_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
    }

    public function ajax_rekening_bank(Request $request)
    {
        $norek = Rekening::where('kode_perusahaan', $request->perusahaanrek_id)->pluck('norek');
        return response()->json($norek);
    }

    public function ajax_rekening_bank_depo(Request $request)
    {
        $norek = Rekening::where('kode_depo', $request->deporek_id)->pluck('norek');
        return response()->json($norek);
    }

    public function ajax_rekening_va(Request $request)
    {
        $nova = Virtualaccount::where('norek', $request->norekk)->pluck('virtualaccount');
        return response()->json($nova);
    }

    public function index(Request $request)
    {
        //$rekening = DB::table('rekenings')->get(); 

        $perusahaan_dms = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $perusahaan_bank = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        
        // $depo_dms = Depo::where('kode_perusahaan', 'TUA')->orderBy('kode_depo', 'ASC')->get();
        // $depo_bank = Depo::where('kode_perusahaan', 'TUA')->orderBy('kode_depo', 'ASC')->get();

        $kredit = DB::table('catatan_rekenings')
                    ->where('tanggal_rek','')->get();
        $kredit_dms = DB::connection('mysql_tua')
                        ->table('dms_cas_docbgreceipt')
                        ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                        ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                        ->whereBetween('dms_cas_docbgreceipt.dtmDoc', ['',''])
                        ->get();
        return view('rekon.kredit.index', compact('kredit','kredit_dms','perusahaan_dms','perusahaan_bank')); //,'depo_dms','depo_bank','rekening'
    }

    public function dmscari(Request $request)
    {
        //DMS
        $start_dms = '';
        $end_dms = '';

        if(request()->date_dms != ''){
            $date_dms = explode(' - ' ,request()->date_dms);
            $start_dms = Carbon::parse($date_dms[0])->format('Y-m-d');
            $end_dms = Carbon::parse($date_dms[1])->format('Y-m-d');
        }

        if(request()->depo_dms != '')
        {
            $pilihdepo = request()->depo_dms;
            $kode_depo_dms = request()->nama_depo;
        }

        if ($pilihdepo == '')
        {
            $kredit_dms = DB::connection('mysql_tua')
                        ->table('dms_cas_docbgreceipt')
                        ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                        ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                        ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                        ->get();
        }else{
            $kredit_dms = DB::connection('mysql_tua')
                        ->table('dms_cas_docbgreceipt')
                        ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                        ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                        ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                        ->where('dms_cas_docbgreceipt.szBranchId', $pilihdepo)->get();
        }

    }

    public function rekeningcari(Request $request)
    {   
        $rekening = DB::table('rekenings')->get(); 
        $perusahaan_dms = DB::table('perusahaans')->get();
        $perusahaan_bank = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        
        $pilihrek = $request->norek;
        $pilihperusahaan = $request->kode_perusahaan;
        $pilihdepo = $request->kode_depo;


        //-----DMS
        if(request()->created_at_dms != ''){
            $date_dms = explode(' - ' ,request()->created_at_dms);
            $start_dms = Carbon::parse($date_dms[0])->format('Y-m-d');
            $end_dms = Carbon::parse($date_dms[1])->format('Y-m-d');
        }


        if(request()->perusahaan_dms == '')
        {

        }elseif(request()->perusahaan_dms == 'TUA'){
            if(request()->depo_dms != '')
            {
                $pilihdepo = request()->depo_dms;
                $kode_depo_dms = request()->nama_depo;
            }

            

            if ($pilihdepo == '')
            {
                $kredit_dms = DB::connection('mysql_tua')
                            ->table('dms_cas_docbgreceipt')
                            ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                            ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                            ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                            ->get();
            }else{
                $kredit_dms = DB::connection('mysql_tua')
                            ->table('dms_cas_docbgreceipt')
                            ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                            ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                            ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                            ->where('dms_cas_docbgreceipt.szBranchId', $pilihdepo)->get();
            }

        }elseif(request()->perusahaan_dms == 'LP'){
            if(request()->depo_dms != '')
            {
                $pilihdepo = request()->depo_dms;
                $kode_depo_dms = request()->nama_depo;
            }

            

            if ($pilihdepo == '')
            {
                $kredit_dms = DB::connection('mysql_tu')
                            ->table('dms_cas_docbgreceipt')
                            ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                            ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                            ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                            ->get();
            }else{
                $kredit_dms = DB::connection('mysql_tu')
                            ->table('dms_cas_docbgreceipt')
                            ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                            ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                            ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                            ->where('dms_cas_docbgreceipt.szBranchId', $pilihdepo)->get();
            }
        }elseif(request()->perusahaan_dms == 'WPS'){
            if(request()->depo_dms != '')
            {
                $pilihdepo = request()->depo_dms;
                $kode_depo_dms = request()->nama_depo;
            }   

            if ($pilihdepo == '')
            {
                $kredit_dms = DB::connection('mysql_ta')
                            ->table('dms_cas_docbgreceipt')
                            ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                            ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                            ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                            ->get();
            }else{
                $kredit_dms = DB::connection('mysql_ta')
                            ->table('dms_cas_docbgreceipt')
                            ->join('dms_cas_docbgreceiptitem','dms_cas_docbgreceipt.szdocid','=','dms_cas_docbgreceiptitem.szDocId')
                            ->join('dms_ar_customer','dms_cas_docbgreceiptitem.szCustomerId','=','dms_ar_customer.szId')
                            ->whereBetween('dms_cas_docbgreceipt.dtmDoc', [$start_dms, $end_dms])
                            ->where('dms_cas_docbgreceipt.szBranchId', $pilihdepo)->get();
            }
        }

        $total_row = $kredit_dms->count();
       
        //-----REKENING
        if(request()->created_at_bank != ''){
            $date_bank = explode(' - ' ,request()->created_at_bank);
            $start_bank = Carbon::parse($date_bank[0])->format('Y-m-d');
            $end_bank = Carbon::parse($date_bank[1])->format('Y-m-d');
        }

        if ($pilihrek == '')
        {
            //$kredit = DB::table('catatan_rekenings')->get();
            $kredit = MutasiRekening::whereBetween('tanggal_rek', [$start_bank, $end_bank])
                                    ->get();
        }else{
            $kredit = MutasiRekening::whereBetween('tanggal_rek', [$start_bank, $end_bank])
                                    ->where('norek',$pilihrek)->get();
        }
        return view('rekon.kredit.index', compact('kredit','kredit_dms','perusahaan_dms','perusahaan_bank','rekening','total_row'));
    }

    public function store(Request $request)
    {
        //----DMS----//
        $datas=[];
        foreach ($request->input('id_cek') as $key => $value) {
            
        }

        $validator = Validator::make($request->all(), $datas);

            foreach ($request->input("id_cek") as $key => $value) {
                $getRow = DB::table('catatan_non_tunai_kredit_perusahaan')->select(DB::raw('MAX(RIGHT(kode_doc,6)) as NoUrut'))
                        ->where('kode_doc', 'like', "%".$date."%");
                $rowCount = $getRow->count();
                if ($rowCount > 0) {
                    if ($rowCount < 9) {
                        $kode = $date_1."-"."00000".''.($rowCount + 1);
                    }elseif ($rowCount < 99) {
                        $kode = $date_1."-"."0000".''.($rowCount + 1);
                    }elseif ($rowCount < 999) {
                        $kode = $date_1."-"."000".''.($rowCount + 1);
                    }elseif ($rowCount < 9999) {
                        $kode = $date_1."-"."00".''.($rowCount + 1);
                    }elseif ($rowCount < 99999) {
                        $kode = $date_1."-"."0".''.($rowCount + 1);
                    }else{
                        $kode = $date_1."-".($rowCount + 1);
                    }
                }else{
                    $kode = $date_1."-".sprintf("%06s", 1);
                }

                $data = new CatatanNonTunaiKreditPerusahaan;

                $data->kode_doc = $kode;
                $data->tanggal_btu = $request->get("tgl")[$key];
                $data->no_transaksi = $request->get("no_tran")[$key];
                $data->kode_perusahaan = $request->get("type_id")[$key];
                $data->kode_depo = $request->get("type_id")[$key];
                $data->kode_toko = $request->get("kode_toko")[$key];
                $data->id_cek = $request->get("id_cek")[$key];
                $data->nilai = $request->get("nilai")[$key];
                $data->jatuh_tempo = $request->get("jt")[$key];
                $data->norek = $request->get("norek_dms")[$key];
                $data->no_transaksi_lawan = $request->get("transaksi_lawan_d_")[$key];
                $data->tanggal_validasi = Carbon::now()->format('Y-m-d');
                $data->status = 1;
                $data->id_user_input = Auth::user()->id;
                $data->save();
            
        }

        //----BANK----//
        $datas_bank=[];
        foreach ($request->input('desk') as $key => $value) {
            
        }

        $validator = Validator::make($request->all(), $datas_bank);

        if($validator->passes()){
            foreach ($request->input("desk") as $key => $value) {
                $data = new CatatanNonTunaiKreditBank;

                $data->kode_doc = $kode;
                $data->tanggal_rek = $request->get("tgl_rek")[$key];
                $data->no_transaksi = $request->get("no_tran_rek")[$key];
                $data->deskripsi = $request->get("desk")[$key];
                $data->nilai = $request->get("nilai_rek")[$key];
                $data->norek = $request->get("norek_bank")[$key];
                $data->no_transaksi_lawan = $request->get("transaksi_lawan_b_")[$key];
                $data->tanggal_btu = $request->get("tgl_btu")[$key];
                $data->tanggal_validasi = Carbon::now()->format('Y-m-d');
                $data->status = 1;
                $data->id_user_input = Auth::user()->id;
                $data->save();

                $catatan_rekening_update = CatatanRekening::find($request->get('no_tran_rek')[$key]);
                $catatan_rekening_update->update([
                    'status' => '1'
                ]);
            }
        }

        alert()->success('Sukses.','Data Transaksi berhasil tersimpan');
        // return redirect()->route('pengajuan.index');
    }

    
}
