<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringChequeController extends Controller
{
    public function index()
    {
        $data_tampung = DB::table('rekening_fin_comp')
                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                        ->select(
                                    'rekening_fin_comp.norek',
                                    'rekening_fin_comp.kode_perusahaan',
                                    'perusahaans.nama_perusahaan',
                                    'rekening_fin_comp.kode_bank',
                                    'banks.nama_bank',
                                    'rekening_fin_comp.fungsi_rek',
                                    'rekening_fin_comp.internet_banking',
                                    'rekening_fin_comp.token',
                                    'rekening_fin_comp.jml_pemegang_token_viewer',
                                    'rekening_fin_comp.jml_pemegang_token_maker',
                                    'rekening_fin_comp.jml_pemegang_token_verifier',
                                    'rekening_fin_comp.jml_pemegang_token_authorizer'
                                )
                        ->where('rekening_fin_comp.fungsi_rek', 'Tampung Otomatis')
                        ->get();
            
        $data_master = DB::table('rekening_fin_comp')
                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                        ->select(
                                    'rekening_fin_comp.norek',
                                    'rekening_fin_comp.kode_perusahaan',
                                    'perusahaans.nama_perusahaan',
                                    'rekening_fin_comp.kode_bank',
                                    'banks.nama_bank',
                                    'rekening_fin_comp.fungsi_rek',
                                    'rekening_fin_comp.internet_banking',
                                    'rekening_fin_comp.token',
                                    'rekening_fin_comp.jml_pemegang_token_viewer',
                                    'rekening_fin_comp.jml_pemegang_token_maker',
                                    'rekening_fin_comp.jml_pemegang_token_verifier',
                                    'rekening_fin_comp.jml_pemegang_token_authorizer'
                                )
                        ->where('rekening_fin_comp.fungsi_rek', 'Master')
                        ->get();

        $data_biaya = DB::table('rekening_fin_comp')
                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                        ->select(
                                    'rekening_fin_comp.norek',
                                    'rekening_fin_comp.kode_perusahaan',
                                    'perusahaans.nama_perusahaan',
                                    'rekening_fin_comp.kode_bank',
                                    'banks.nama_bank',
                                    'rekening_fin_comp.fungsi_rek',
                                    'rekening_fin_comp.internet_banking',
                                    'rekening_fin_comp.token',
                                    'rekening_fin_comp.jml_pemegang_token_viewer',
                                    'rekening_fin_comp.jml_pemegang_token_maker',
                                    'rekening_fin_comp.jml_pemegang_token_verifier',
                                    'rekening_fin_comp.jml_pemegang_token_authorizer'
                                )
                        ->where('rekening_fin_comp.fungsi_rek', 'Biaya')
                        ->get();

        return view ('bod.master_bod.monitoring_cheque.index', compact('data_tampung','data_master','data_biaya'));
    }


}
