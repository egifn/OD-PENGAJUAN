<?php

namespace App\Http\Controllers\Bod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaftarPengajuanBiayaClaimPerhitunganController extends Controller
{
    public function index()
    {
        return view ('bod.daftar_biaya_claim_perhitungan.index'); //, compact('data_pengajuan_claim')
    }
}
