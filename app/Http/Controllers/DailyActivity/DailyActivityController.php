<?php

namespace App\Http\Controllers\DailyActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class DailyActivityController extends Controller
{
    public function index(Request $request)
    {
        return view ('daily_activity.index');
    }

    public function dashboardAreaDom()
    {
        $areas = DB::table('dt_area')->select('id', 'area_name')->get();
        return view('daily_activity.dashboard_area', compact('areas'));
    }

    public function dashboardAreaDomData(Request $request)
    {
        $areaId = $request->input('area_id');

        $area = DB::table('dt_area')->where('id', $areaId)->first();
        if (!$area) return response()->json([]);

        $raw = trim($area->area_group_depo, "'");
        $depoCodes = array_map(function ($c) {
            return trim($c, " '\"");
        }, explode(',', $raw));

        $depoList = DB::table('depos')->whereIn('kode_depo', $depoCodes)->get();

        $data = [];

        foreach ($depoList as $depo) {
            $instruksi = DB::table('daily_activity_h')->where('depo', $depo->kode_depo)->count();
            $terjawab = DB::table('daily_activity_h')
                ->leftJoin('daily_activity_answer', 'daily_activity_h.id', '=', 'daily_activity_answer.id_instruksi')
                ->where('daily_activity_h.depo', $depo->kode_depo)
                ->whereNotNull('daily_activity_answer.id')
                ->count();
            $belum = $instruksi - $terjawab;

            $data[] = [
                'nama_depo' => $depo->nama_depo,
                'instruksi' => $instruksi,
                'terjawab' => $terjawab,
                'belum_terjawab' => $belum,
            ];
        }

        $totalInstruksi = array_sum(array_column($data, 'instruksi'));
        $totalTerjawab  = array_sum(array_column($data, 'terjawab'));
        $totalBelum     = $totalInstruksi - $totalTerjawab;

        return response()->json([
            'area_name' => $area->area_name,
            'total_instruksi' => $totalInstruksi,
            'total_terjawab'  => $totalTerjawab,
            'total_belum'     => $totalBelum,
            'depo_list'       => $data,
        ]);
    }

    public function dialy_activity_asm(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'activity_id' => 'required|integer',
            'peserta' => 'required|string',
            'program' => 'required|string',
            // Add validation for other required fields
        ]);

        try {
            DB::table('daily_activity_answer')->insert([
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'depo' => $request->depo,
                'area' => $request->area,
                'jabatan' => $request->jabatan,
                'id_user' => Auth::user()->id,
                'id_instruksi' => $request->activity_id,
                'peserta' => $request->peserta,
                'program' => $request->program,
                'target' => $request->target,
                'perform' => $request->perform,
                'operation' => $request->operation,
                'outlet' => $request->outlet,
                'keuangan' => $request->keuangan,
                'other' => $request->other,
                'coaching' => $request->coaching,
                'teguran' => $request->teguran,
                'intruksi' => $request->intruksi,
                'warning' => $request->warning,
                'other_eksekusi' => $request->other_eksekusi,
                'channel' => $request->channel,
                'nama_toko' => $request->nama_toko,
                'issue' => $request->issue,
                'key_action' => $request->key_action,
                'sales' => $request->sales,
                'channel_join' => $request->channel_join,
                'issue_join' => $request->issue_join,
                'key_action_join' => $request->key_action_join,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            DB::table('daily_activity_h')
                ->where('id', $request->activity_id)
                ->update([
                    'status' => 1,
                    'tanggal_selesai' => now(),
                    'catatan' => $request->catatan
                ]);


            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Gagal menyimpan data',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    public function view_list(Request $request)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_users = DB::table('users')
                ->leftJoin('divisi_sub','users.kode_sub_divisi','=','divisi_sub.kode_divisi_sub')
                ->select('users.id as id_user', 'divisi_sub.nama_divisi_sub')
                ->where('users.id', Auth::user()->id)
                ->first();

        $data_som = DB::table('daily_activity_h')
                ->join('users','daily_activity_h.id_user','=','users.id')
                ->join('dt_area','daily_activity_h.area','=','dt_area.id')
                ->join('users as asm','daily_activity_h.area','=','asm.id_area')
                ->select('daily_activity_h.id',
                    'daily_activity_h.tanggal',
                    'daily_activity_h.area',
                    'dt_area.area_name',
                    'daily_activity_h.jabatan',
                    'daily_activity_h.id_user',
                    'daily_activity_h.instruksi',
                    'daily_activity_h.status',
                    'daily_activity_h.tanggal_selesai',
                    'dt_area.area_group_depo',
                    'users.name',
                    'asm.name as asm_name')
                ->get();

        $data_ssd = DB::table('daily_activity_d')
                ->join('depos', 'daily_activity_d.depo', '=', 'depos.kode_depo')
                ->join('users as kpj','daily_activity_d.depo','=','kpj.kode_depo')
                ->where('kpj.type', 'Manager')
                ->where('kpj.status_user', 'Aktif')
                ->select(
                    'daily_activity_d.*',
                    'depos.nama_depo',
                    'kpj.name as kpj_name'
                )
                ->get();

        // dd($data_ssd);

        $data = DB::table('daily_activity_h')
                ->join('users','daily_activity_h.id_user','=','users.id')
                ->join('depos','daily_activity_h.depo','=','depos.kode_depo')
                ->select('daily_activity_h.id',
                    'daily_activity_h.tanggal',
                    'daily_activity_h.area',
                    'daily_activity_h.jabatan',
                    'daily_activity_h.id_user',
                    'daily_activity_h.instruksi',
                    'daily_activity_h.status',
                    'daily_activity_h.tanggal_selesai',
                    'depos.nama_depo',
                    'depos.kode_depo',
                    'users.name')
                ->get();
                
        $structuredData = [];
        foreach ($data as $val) {
            // Get daily_activity_d data for this activity
            $depoData = DB::table('daily_activity_d')
                ->join('depos', 'daily_activity_d.depo', '=', 'depos.kode_depo')
                // ->where('daily_activity_d.depo', $val->kode_depo)
                ->where('daily_activity_d.tanggal', $val->tanggal)
                ->select(
                    'daily_activity_d.*',
                    'depos.nama_depo'
                )
                ->get();

            $structuredData[] = [
                'id' => $val->id,
                'name' => $val->name,
                'jabatan' => $val->jabatan,
                'tanggal' => $val->tanggal,
                'instruksi' => $val->instruksi,
                'status' => $val->status,
                'tanggal_selesai' => $val->tanggal_selesai,
                'depo' => $depoData->toArray(),
                'kode_depo' => $val->kode_depo,
                'nama_depo' => $val->nama_depo
            ];
        }

        $data_asm = $structuredData;

        return view ('daily_activity.list', compact('data_som','data_users','data_asm','data_ssd'));
    }

    public function cari(Request $request)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data = DB::table('daily_activity_h')
                ->join('users','daily_activity_h.id_user','=','users.id')
                ->join('depos','daily_activity_h.depo','=','depos.kode_depo')
                ->select('daily_activity_h.id',
                    'daily_activity_h.tanggal',
                    'daily_activity_h.depo',
                    'depos.nama_depo',
                    'depos.area',
                    'daily_activity_h.jabatan',
                    'daily_activity_h.id_user',
                    'users.name')
                //->WhereBetween('daily_activity.tanggal', [$date_start,$date_end])
                //->where('daily_activity.id_user', Auth::user()->id)
                ->get();

        return view ('daily_activity.list', compact('data'));
    }

    public function view($id)
    {
        $data_users = DB::table('users')
                      ->join('depos','users.kode_depo','=','depos.kode_depo')
                      ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                      ->leftjoin('divisi_sub','users.kode_sub_divisi','=','divisi_sub.kode_divisi_sub')
                      ->leftjoin('dt_area','users.id_area','=','dt_area.id')
                      ->leftjoin('dt_segment','users.id_segmen','=','dt_segment.id')
                      ->select('users.id as id_user',
                                'depos.nama_depo',
                                'dt_area.area_name',
                                'divisi_sub.nama_divisi_sub')
                      ->where('users.id', Auth::user()->id)
                      ->first();
        // dd($data_users);

        $data_view = DB::table('daily_activity_h')
                    ->join('users','daily_activity_h.id_user','=','users.id')
                    ->select(
                        'daily_activity_h.id as id_activity',
                        'daily_activity_h.tanggal',
                        'daily_activity_h.depo',
                        'daily_activity_h.area',
                        'daily_activity_h.jabatan',
                        'daily_activity_h.id_user',
                        'daily_activity_h.instruksi',
                        'daily_activity_h.status',
                        'daily_activity_h.tanggal_selesai',
                        'daily_activity_h.catatan',
                        'users.name',
                    )
                    ->Where('daily_activity_h.id', $id)
                    ->first();

        return view ('daily_activity.view', compact('data_view','data_users'));
    }

    public function update(Request $request)
    {
        $update_data = DB::table('daily_activity')
                        ->where('daily_activity.id', $request->get("id"))
                        ->update([
                            // 'description' => $request->get("kode_perusahaan_tujuan"),
                            // 'spesifikasi' => $request->get("id_program_simpan"),
                            // 'qty' => '1',
                            // 'harga' => $request->get("total_reward_tiv"),
                            // 'potongan' => $request->get("total_potongan"),
                            // 'tharga' => $request->get("hasil_total")

                            'chk_gt_so' => $request->chk1,
                            'gt_so_action' => $request->gt_so2,
                            'chk_gt_ws' => $request->chk2,
                            'gt_ws_action' => $request->gt_ws2,
                            'chk_gt_r' => $request->chk3,
                            'gt_r_action' => $request->gt_r2,
                            'chk_gt_ahs' => $request->chk4,
                            'gt_ahs_action' => $request->gt_ahs2,
                            'chk_gt_iod' => $request->chk5,
                            'gt_iod_action' => $request->gt_iod2,
                            'chk_gt_afh' => $request->chk6,
                            'gt_afh_action' => $request->gt_afh2,
                            'chk_gt_mt' => $request->chk7,
                            'gt_mt_action' => $request->gt_mt2,
                            'peserta' => $request->peserta,
                            'program' => $request->program, 
                            'target' => $request->target,
                            'perform' => $request->pp,
                            'operation' => $request->opr,
                            'outlet' => $request->outlet,
                            'keuangan' => $request->keuangan,
                            'other' => $request->other,
                            'coaching' => $request->coaching,
                            'teguran' => $request->teguran,
                            'intruksi' => $request->intruksi,
                            'warning' => $request->warning,
                            'other_eksekusi' => $request->other_eksekusi,
                            'channel' => $request->channel,
                            'nama_toko' => $request->nama_toko,
                            'issue' => $request->issue,
                            'key_action' => $request->key_action,
                            'sales' => $request->sales,
                            'channel_join' => $request->channel_join,
                            'issue_join' => $request->issue_join,
                            'key_action_join' => $request->key_action_join
                        ]);

        return redirect()->route('daily_activity.list');
    }


    public function modalDetail(Request $request)
    {
        // dd($request->all());
        $id = $request->id;

        // Handle modal untuk data utama (existing code)
        $header = DB::table('daily_activity_h')
                    ->select('*')
                    ->where('id', $id)
                    ->first();

        $answer = DB::table('daily_activity_answer')
            ->where('id_instruksi', $id)
            ->first();

        return response()->json([
        'type' => 'main',
        'header' => $header,
        'answer' => $answer
        ]);
        
    }
}
