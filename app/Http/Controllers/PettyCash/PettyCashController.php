<?php

namespace App\Http\Controllers\PettyCash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perusahaan;
use App\Depo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PettyCashController extends Controller
{
    public function index()
    {
        
        return view ('petty_cash.index');
    }

    public function create()
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        return view ('petty_cash.create', compact('perusahaan'));
    }

    public function store(Request $request)
    {

    }

    public function update_view()
    {

    }

    public function edit(Request $request)
    {

    }
}
