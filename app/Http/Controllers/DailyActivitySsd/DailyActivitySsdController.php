<?php

namespace App\Http\Controllers\DailyActivitySsd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DailyActivitySsdController extends Controller
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
                                'dt_segment.id as id_segment',
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

        return view ('daily_activity_ssd.index', compact('data_users','depos'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Validasi data input
            $validator = Validator::make($request->all(), [
                'tgl' => 'required|date',
                'kode_depo' => 'required|string|max:50',
                'jabatan' => 'required|string|max:100',
                'segment' => 'required|string|max:255',
                'challenge' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Data yang wajib diisi tidak lengkap!');
            }

            $data = [
                'tanggal' => $request->tgl,
                'depo' => $request->kode_depo,
                'jabatan' => $request->jabatan,
                'id_user' => Auth::id(),
                'challenge' => $request->segment,
                'instruksi' => $request->challenge,
                'created_at' => Carbon::now(),
            ];

            // Debug: log data yang akan disimpan
            Log::info('Attempting to insert into daily_activity_d', [
                'data' => $data,
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name
            ]);

            $id = DB::table('daily_activity_d')->insertGetId($data);
            
            DB::commit();

            Log::info('Data inserted successfully into daily_activity_d', [
                'id' => $id,
                'table' => 'daily_activity_d'
            ]);

            return redirect()->back()
                ->with('success', 'Data berhasil disimpan!')
                ->with('saved_id', $id);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all()));

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error storing to daily_activity_d: ' . $e->getMessage(), [
                'request_data' => $request->except(['password', '_token']),
                'user_id' => Auth::id(),
                'error_trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function view_list(Request $request)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data = DB::table('daily_activity_d')
                ->join('users','daily_activity_d.id_user','=','users.id')
                ->join('depos','daily_activity_d.depo','=','depos.kode_depo')
                ->select('daily_activity_d.id',
                    'daily_activity_d.tanggal',
                    'daily_activity_d.depo',
                    'depos.nama_depo',
                    'daily_activity_d.jabatan',
                    'daily_activity_d.id_user',
                    'daily_activity_d.challenge',
                    'daily_activity_d.status',
                    'daily_activity_d.catatan',
                    'daily_activity_d.tanggal_selesai',
                    'users.name')
                //->WhereBetween('daily_activity.tanggal', [$date_start,$date_end])
                ->where('daily_activity_d.id_user', Auth::user()->id)
                ->get();

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
                                'dt_segment.id as id_segment',
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

        return view ('daily_activity_ssd.list', compact('data','data_users','depos'));
    }

    public function cari(Request $request)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data = DB::table('daily_activity_h')
                ->join('users','daily_activity.id_user','=','users.id')
                ->join('depos','daily_activity.depo','=','depos.kode_depo')
                ->select('daily_activity.id',
                    'daily_activity.tanggal',
                    'daily_activity.depo',
                    'depos.nama_depo',
                    'daily_activity.area',
                    'daily_activity.jabatan',
                    'daily_activity.id_user',
                    'users.name')
                //->WhereBetween('daily_activity.tanggal', [$date_start,$date_end])
                ->where('daily_activity.id_user', Auth::user()->id)
                ->get();

        return view ('daily_activity_ssd.list', compact('data'));
    }

    public function view($id)
    {
        $data_view = DB::table('daily_activity_h')
                ->join('users','daily_activity.id_user','=','users.id')
                ->join('depos','daily_activity.depo','=','depos.kode_depo')
                ->Where('daily_activity.id', $id)
                ->first();

        return view ('daily_activity_ssd.view', compact('data_view'));
    }

    public function update(Request $request)
    {

    }
}
