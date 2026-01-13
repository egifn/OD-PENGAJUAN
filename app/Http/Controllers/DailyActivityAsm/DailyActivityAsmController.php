<?php

namespace App\Http\Controllers\DailyActivityAsm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DailyActivityAsmController extends Controller
{
    public function index(Request $request)
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
                                'divisi_sub.nama_divisi_sub',
                                'dt_segment.name as segment')
                      ->where('users.id', Auth::user()->id)
                      ->first();

        $depos = DB::table('depos')
                ->whereNotIn('kode_depo', [
                    '000','001','002','003','004','005','006','007','034-W01','034-W02','111','222',
                    '916','337','911','033','342','917','919','910','341','036','920','908','031',
                    '901','925','021','335','915','906','032','926'
                ])
                ->orderBy('kode_perusahaan')
                ->get();

                // dd($depos);

        return view ('daily_activity_asm.index', compact('data_users','depos'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $data = [
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'depo' => $request->depo,
                'area' => $request->area,
                'jabatan' => $request->jabatan,
                'id_user' => Auth::id(),
                'key_challenge' => $request->key_challenge,
                'gt_so_challenge' => $request->gt_so1,
                'chk_gt_so' => $request->chk1 ?? 0, // default value jika null
                'gt_so_action' => $request->gt_so2,
                'gt_ws_challenge' => $request->gt_ws1,
                'chk_gt_ws' => $request->chk2 ?? 0,
                'gt_ws_action' => $request->gt_ws2,
                'gt_r_challenge' => $request->gt_r1,
                'chk_gt_r' => $request->chk3 ?? 0,
                'gt_r_action' => $request->gt_r2,
                'gt_ahs_challenge' => $request->gt_ahs1,
                'chk_gt_ahs' => $request->chk4 ?? 0,
                'gt_ahs_action' => $request->gt_ahs2,
                'gt_iod_challenge' => $request->gt_iod1,
                'chk_gt_iod' => $request->chk5 ?? 0,
                'gt_iod_action' => $request->gt_iod2,
                'gt_afh_challenge' => $request->gt_afh1,
                'chk_gt_afh' => $request->chk6 ?? 0,
                'gt_afh_action' => $request->gt_afh2,
                'gt_mt_challenge' => $request->gt_mt1,
                'chk_gt_mt' => $request->chk7 ?? 0,
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
                'key_action_join' => $request->key_action_join,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Validasi data penting
            $validator = Validator::make($data, [
                'depo' => 'required',
                'jabatan' => 'required',
                'id_user' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validasi gagal!');
            }

            $id = DB::table('daily_activity')->insertGetId($data);
            
            DB::commit();

            // Log success
            Log::info('Daily activity created successfully', [
                'id' => $id,
                'user_id' => Auth::id(),
                'depo' => $request->depo
            ]);

            return redirect()->back()
                ->with('success', 'Produk berhasil disimpan!')
                ->with('saved_id', $id); // Optional: kirim ID yang baru dibuat

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error
            Log::error('Error storing daily activity: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->except(['password', '_token'])
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $data = [
                'tanggal' => $request->tgl,
                'depo' => $request->kode_depos,
                'jabatan' => strtoupper($request->jabatan),
                'id_user' => Auth::id(),
                'instruksi' => $request->key_challenge,
                'created_at' => Carbon::now(),
            ];

            // Validasi data
            $validator = Validator::make($data, [
                'depo' => 'required',
                'jabatan' => 'required',
                'instruksi' => 'required',
                'id_user' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validasi gagal!');
            }

            $id = DB::table('daily_activity_h')->insertGetId($data);
            
            DB::commit();

            // Log success
            Log::info('Daily activity instruction created successfully', [
                'id' => $id,
                'user_id' => Auth::id(),
                'depo' => $request->kode_depos
            ]);

            return redirect()->back()
                ->with('success', 'Instruksi berhasil disimpan!')
                ->with('saved_id', $id);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error
            Log::error('Error storing daily activity instruction: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->except(['password', '_token'])
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function daily_activity_asm(Request $request)
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
                    'users.name')
                //->WhereBetween('daily_activity_h.tanggal', [$date_start,$date_end])
                ->where('daily_activity_h.area', Auth::user()->id_area)
                ->get();

        $data_area = DB::table('dt_area')
            ->select('area_group_depo')
            ->where('id', Auth::user()->id_area)
            ->first();

        $area = explode(",", str_replace("'", "", $data_area->area_group_depo));

        $depos = DB::table('depos')
        ->whereIn('kode_depo', $area)
        ->select('*')
        ->get();
        
        // dd($depos);
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
                //->WhereBetween('daily_activity_h.tanggal', [$date_start,$date_end])
                ->where('daily_activity_h.id_user', Auth::user()->id)
                ->get();

        $structuredData = [];
        foreach ($data as $val) {
            // Get daily_activity_d data for this activity
            $depoData = DB::table('daily_activity_d')
                ->join('depos', 'daily_activity_d.depo', '=', 'depos.kode_depo')
                ->where('daily_activity_d.depo', $val->kode_depo)
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

        return view ('daily_activity_asm.list', compact('data_som','data_users','depos','data_asm'));
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

        return view ('daily_activity_asm.list', compact('data'));
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

        return view ('daily_activity_asm.view', compact('data_view','data_users'));
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

        return redirect()->route('daily_activity_asm.list');
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
