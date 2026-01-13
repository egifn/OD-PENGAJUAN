<?php

namespace App\Http\Controllers\DailyActivityKpj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyActivityKpjController extends Controller
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

        return view ('daily_activity_kpj.index', compact('data_users'));
    }

   public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'id_instruksi' => 'required|exists:daily_activity_h,id',
            'peserta' => 'nullable|string',
            'program' => 'nullable|string',
            'target' => 'nullable|string',
            'perform' => 'nullable|string',
            'operation' => 'nullable|string',
            'outlet' => 'nullable|string',
            'keuangan' => 'nullable|string',
            'other' => 'nullable|string',
            'coaching' => 'nullable|string',
            'teguran' => 'nullable|string',
            'intruksi' => 'nullable|string',
            'warning' => 'nullable|string',
            'other_eksekusi' => 'nullable|string',
            'channel' => 'nullable|string',
            'nama_toko' => 'nullable|string',
            'issue' => 'nullable|string',
            'key_action' => 'nullable|string',
            'sales' => 'nullable|string',
            'channel_join' => 'nullable|string',
            'issue_join' => 'nullable|string',
            'key_action_join' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Insert main activity response
            $responseId = DB::table('daily_activity_answer')->insert([
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'depo' => $request->kode_depo,
                'id_user' => Auth::id(),
                'id_instruksi' => $request->id_instruksi,
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

              DB::table('daily_activity_h')
                        ->where('id', $request->id_instruksi)
                        ->update([
                            'status' => 1,
                            'catatan' => $request->catatan,
                            'tanggal_selesai' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

            // Insert challenge notes if exists
            if (is_array($request->ssd)) {
                foreach ($request->ssd as $note) {
                    DB::table('daily_activity_d')
                        ->where('id', $note['id'])
                        ->update([
                            'status' => 1,
                            'catatan' => $note['catatan'],
                            'tanggal_selesai' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                }
            }

            // Update the original activity status
            DB::table('daily_activity_h')
                ->where('id', $request->id_instruksi)
                ->update([
                    'status' => 1,
                    'tanggal_selesai' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

            DB::commit();

            // dd('Jawaban aktivitas berhasil disimpan!');

            return response()->json([
                'success' => true,
                'message' => 'Jawaban aktivitas berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function view_list(Request $request)
    {
        $date_start = date('Y-m-d');
        $date_end = date('Y-m-d');

        // Get user data
        $data_users = DB::table('users')
            ->leftJoin('divisi_sub','users.kode_sub_divisi','=','divisi_sub.kode_divisi_sub')
            ->select('users.id as id_user', 'divisi_sub.nama_divisi_sub')
            ->where('users.id', Auth::user()->id)
            ->first();

        // Get main activity data
        $data = DB::table('daily_activity_h')
                ->join('users','daily_activity_h.id_user','=','users.id')
                ->join('depos','daily_activity_h.depo','=','depos.kode_depo')
                ->select(
                    'daily_activity_h.id',
                    'daily_activity_h.tanggal',
                    'daily_activity_h.area',
                    'daily_activity_h.jabatan',
                    'daily_activity_h.id_user',
                    'daily_activity_h.instruksi',
                    'daily_activity_h.status',
                    'daily_activity_h.tanggal_selesai',
                    'depos.nama_depo',
                    'depos.kode_depo',
                    'users.name'
                )
                ->where('daily_activity_h.depo', Auth::user()->kode_depo)
                ->get();

        // Structure the data with depo information
        $structuredData = [];
        foreach ($data as $val) {
            // Get daily_activity_d data for this activity
            $depoData = DB::table('daily_activity_d')
                ->join('depos', 'daily_activity_d.depo', '=', 'depos.kode_depo')
                ->where('daily_activity_d.depo', Auth::user()->kode_depo)
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

        // dd($structuredData);

            // dd($structuredData);
        return view('daily_activity_kpj.list', [
            'data' => $structuredData,
            'data_users' => $data_users
        ]);
    }

    public function cari(Request $request)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data = DB::table('daily_activity_h')
                ->join('users','daily_activity.id_user','=','users.id')
                ->select('daily_activity.id',
                    'daily_activity.tanggal',
                    'daily_activity.depo',
                    'daily_activity.area',
                    'daily_activity.jabatan',
                    'daily_activity.id_user',
                    'users.name')
                ->WhereBetween('daily_activity.tanggal', [$date_start,$date_end])
                ->get();

        return view ('daily_activity.list', compact('data'));
    }

    public function view($id)
    {
        $data_view = DB::table('daily_activity_h')
                ->join('users','daily_activity.id_user','=','users.id')
                ->Where('daily_activity.id', $id)
                ->first();

        return view ('daily_activity.view', compact('data_view'));
    }

    public function update(Request $request)
    {

    }

     public function modalDetail(Request $request)
    {
        $id = $request->id;

        // Handle modal untuk data utama (existing code)
        $header = DB::table('daily_activity_h')
                    ->select('*')
                    ->where('id', $id)
                    ->first();

        $answer = DB::table('daily_activity_answer')
            ->where('id_instruksi', $id)
            ->first();
                // dd($header);
        return response()->json([
            'type' => 'main',
            'header' => $header,
            'answer' => $answer
        ]);
        
    }
}
