<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BodBankCompanyController extends Controller
{
    public function index()
    {
        $data_perusahaan = DB::table('perusahaans')
                            ->select('perusahaans.kode_perusahaan',
                                    'perusahaans.nama_perusahaan',
                                    DB::raw('count(distinct rekening_fin_comp.kode_bank) as jml_bank'))
                            ->join('rekening_fin_comp','perusahaans.kode_perusahaan','=','rekening_fin_comp.kode_perusahaan')
                            ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                            ->groupBy('perusahaans.kode_perusahaan',
                                    'perusahaans.nama_perusahaan')
                            ->orderBy('perusahaans.nama_perusahaan', 'ASC')
                            ->get();

        foreach ($data_perusahaan as $perusahaan) {
                $perusahaan->banks = DB::table('banks')
                                    ->join('rekening_fin_comp', 'banks.kode_bank', '=', 'rekening_fin_comp.kode_bank')
                                    ->where('rekening_fin_comp.kode_perusahaan', $perusahaan->kode_perusahaan)
                                    ->select('banks.kode_bank','banks.nama_bank', DB::raw('count(rekening_fin_comp.norek) as jml_rekening'))
                                    ->groupBy('banks.kode_bank','banks.nama_bank')
                                    ->get();
        }

        return view ('bod.master_bod.bank_company.index', compact('data_perusahaan'));
    }

    public function getBanks($kode_perusahaan)
    {
        $banks = DB::table('banks')
            ->join('rekening_fin_comp', 'banks.kode_bank', '=', 'rekening_fin_comp.kode_bank')
            ->where('rekening_fin_comp.kode_perusahaan', $kode_perusahaan)
            ->select('banks.kode_bank','banks.nama_bank', DB::raw('count(rekening_fin_comp.norek) as jml_rekening'))
            ->groupBy('banks.kode_bank','banks.nama_bank')
            ->get();
            
        return response()->json($banks);
    }

    public function getRekenings($kode_perusahaan, $kode_bank)
    {
        $rekenings = DB::table('rekening_fin_comp')
            ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
            ->leftJoin('rekening_fin_comp_pemegang','rekening_fin_comp.norek','rekening_fin_comp_pemegang.no_rekening')
            ->where('rekening_fin_comp.kode_perusahaan', $kode_perusahaan)
            ->where('banks.kode_bank', $kode_bank)
            ->select('rekening_fin_comp.norek',
                    'rekening_fin_comp.keterangan',
                    'rekening_fin_comp.fungsi_rek',
                    'rekening_fin_comp.internet_banking',
                    'rekening_fin_comp.token',
                    'rekening_fin_comp.cheque',
                    DB::raw('count(rekening_fin_comp_pemegang.id_user_pemegang_viewer) as jml_pemegang_token_viewer'),
                    DB::raw('count(rekening_fin_comp_pemegang.id_user_pemegang_maker) as jml_pemegang_token_maker'),
                    DB::raw('count(rekening_fin_comp_pemegang.id_user_pemegang_verifier) as jml_pemegang_token_verifier'),
                    DB::raw('count(rekening_fin_comp_pemegang.id_user_pemegang_autorizer) as jml_pemegang_token_autorizer'))
            ->groupBy('rekening_fin_comp.norek',
                      'rekening_fin_comp.keterangan',
                      'rekening_fin_comp.fungsi_rek',
                      'rekening_fin_comp.internet_banking',
                      'rekening_fin_comp.token',
                      'rekening_fin_comp.cheque')
            ->get();

        return response()->json($rekenings);
    }

    public function getPemegang($kode_perusahaan, $kode_bank)
    {
        $pemegang = DB::table('rekening_fin_comp')
            ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
            ->leftJoin('rekening_fin_comp_pemegang','rekening_fin_comp.norek','rekening_fin_comp_pemegang.no_rekening')
            ->leftJoin('users AS viewer','rekening_fin_comp_pemegang.id_user_pemegang_viewer','viewer.id')
            ->leftJoin('users AS maker','rekening_fin_comp_pemegang.id_user_pemegang_maker','maker.id')
            ->leftJoin('users AS verifier','rekening_fin_comp_pemegang.id_user_pemegang_verifier','verifier.id')
            ->leftJoin('users AS autorizer','rekening_fin_comp_pemegang.id_user_pemegang_autorizer','autorizer.id')
            ->where('rekening_fin_comp.kode_perusahaan', $kode_perusahaan)
            ->where('banks.kode_bank', $kode_bank)
            ->select('rekening_fin_comp.norek',
                     'viewer.name AS name_viewer',
                     'maker.name AS name_maker',
                     'verifier.name AS name_verifier',
                     'autorizer.name AS name_autorizer')
            ->get();

        
        
        return response()->json($pemegang);
    }
}
