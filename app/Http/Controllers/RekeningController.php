<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Rekening;
use App\Perusahaan;
use App\Depo;
use App\Bank;
use DB;

class RekeningController extends Controller
{
    public function index()
    {
        $rekening = DB::table('rekenings')->join('banks', 'rekenings.kode_bank', '=', 'banks.kode_bank')
            ->join('perusahaans', 'rekenings.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->leftJoin('depos', 'rekenings.kode_depo', '=', 'depos.kode_depo')->get();

        return view('rekon.rekening.index', compact('rekening'));
    }

    public function create()
    {
        $bank = Bank::orderBy('nama_bank', 'DESC')->get();
        $depo = Depo::orderBy('nama_depo', 'DESC')->get();
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'DESC')->get();
        return view('rekon.rekening.create', compact('perusahaan', 'depo', 'bank'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'norek' => 'required|string|max:255',
            'kode_bank' => 'required|',
            'kode_perusahaan' => 'required|string|',
            'kode_depo' => 'string'
        ]);

        Rekening::create([
            'norek' => $request->get('norek'),
            'kode_bank' => $request->get('kode_bank'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kode_depo' => $request->get('kode_depo')
        ]);
        return redirect(route('rekening.index'))->with(['success' => 'Rekening baru berhasil ditambahkan']);
    }

    public function destroy($norek)
    {
        Rekening::find($norek)->delete();
        return redirect(route('rekening.index'))->with(['success' => 'Rekening yang dipilih berhasil dihapus']);
    }
}
