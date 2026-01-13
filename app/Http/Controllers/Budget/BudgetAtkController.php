<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perusahaan;
use App\Depo;
use App\Divisi;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BudgetAtkController extends Controller
{
    public function index()
    {
        $data_budget = DB::table('budget_atk')
                        ->join('perusahaans','budget_atk.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','budget_atk.kode_depo','=','depos.kode_depo')
                        ->join('divisi','budget_atk.kode_divisi','=','divisi.kode_divisi')
                        ->select('budget_atk.kode_budget','budget_atk.kode_perusahaan','budget_atk.kode_depo','budget_atk.kode_divisi','budget_atk.budget',
                                    'perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi')
                        ->get();

        if (request()->q != '') {
            $data_budget = DB::table('budget_atk')
                            ->join('perusahaans','budget_atk.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','budget_atk.kode_depo','=','depos.kode_depo')
                            ->join('divisi','budget_atk.kode_divisi','=','divisi.kode_divisi')
                            ->select('budget_atk.kode_budget','budget_atk.kode_perusahaan','budget_atk.kode_depo','budget_atk.kode_divisi','budget_atk.budget',
                                    'perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi')
                            ->where('perusahaans.nama_perusahaan', 'like', '%' . request()->q . '%')
                            ->orWhere('depos.nama_depo', 'like', '%' . request()->q . '%')
                            ->orWhere('divisi.nama_divisi', 'like', '%' . request()->q . '%')
                            ->get();
        }
        
        return view ('budget_atk.index', compact('data_budget'));
    }

    public function ajax_depo_budget(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
    }

    public function create(Request $request)
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();

        return view ('budget_atk.create', compact('perusahaan','divisi'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        DB::table('budget_atk')->insert([
            'kode_perusahaan' => $request->kode_perusahaan,
            'kode_depo' => $request->kode_depo,
            'kode_divisi' => $request->kode_divisi,
            'budget' => str_replace(",", "", $request->budget),
            'id_user_input' => Auth::user()->id,
        ]);

        alert()->success('Success.','Budget berhasil ditambahkan');
        return redirect()->route('budget_atk.index');
    }

    public function update_view($id)
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();

        $data_budget_update = DB::table('budget_atk')
                        ->join('perusahaans','budget_atk.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','budget_atk.kode_depo','=','depos.kode_depo')
                        ->join('divisi','budget_atk.kode_divisi','=','divisi.kode_divisi')
                        ->select('budget_atk.kode_budget','budget_atk.kode_perusahaan','budget_atk.kode_depo','budget_atk.kode_divisi','budget_atk.budget',
                                    'perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi')
                        ->Where('budget_atk.kode_budget', $id)
                        ->first();
                    
        return view ('budget_atk.update',compact('perusahaan','divisi','data_budget_update'));
    }

    public function edit(Request $request)
    {
        $edit = DB::table('budget_atk')->where('budget_atk.kode_budget', $request->get('kode_budget'))->update([
            'kode_perusahaan' => $request->get("kode_perusahaan"),
            'kode_depo' => $request->get("kode_depo"),
            'kode_divisi' => $request->get("kode_divisi"),
            'budget' => str_replace(",", "", $request->get("budget")),
            'id_user_input' => Auth::user()->id
        ]);
        return redirect(route('budget_atk.index'))->with(['success' => 'Data berhasil diubah']);
    }
}
