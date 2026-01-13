<?php

namespace App\Http\Controllers\DailyActivitySom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DailyActivitySomController extends Controller
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

        $area = DB::table('dt_area')
                ->orderBy('id')
                ->get();

        return view ('daily_activity_som.index', compact('data_users','area'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // Validasi data penting
            $validator = Validator::make($request->all(), [
                'tgl' => 'required',
                'jabatan' => 'required',
                'key_challenge' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Data yang wajib diisi tidak lengkap!');
            }

            $data = [
                'tanggal' => $request->tgl,
                // 'depo' => $request->depo,
                'area' => $request->kode_area,
                'jabatan' => strtoupper($request->jabatan),
                'id_user' => Auth::id(),
                'instruksi' => $request->key_challenge,
                'created_at' => Carbon::now(),
            ];

            $id = DB::table('daily_activity_h')->insertGetId($data);

            // Debug: Log data yang disimpan
            Log::info('Data berhasil disimpan', [
                'id' => $id,
                'data' => $data,
                'user' => Auth::user()->name
            ]);

            return redirect()->back()
                ->with('success', 'Instruksi berhasil disimpan!')
                ->with('saved_id', $id);

        } catch (\Exception $e) {
            // Log error detail
            Log::error('Error menyimpan daily_activity_h: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

   public function view_list(Request $request)
    {
        $date_start = $request->input('date_start', date('Y-m-d'));
        $date_end = $request->input('date_end', date('Y-m-d'));

        // Get main activity data
        $data = DB::table('daily_activity_h')
            ->join('users', 'daily_activity_h.id_user', '=', 'users.id')
            ->join('dt_area', 'daily_activity_h.area', '=', 'dt_area.id')
            ->select(
                'daily_activity_h.id',
                'daily_activity_h.tanggal',
                'dt_area.area_group_depo',
                'dt_area.area_name',
                'daily_activity_h.jabatan',
                'daily_activity_h.id_user',
                'daily_activity_h.status',
                'daily_activity_h.instruksi',
                'daily_activity_h.tanggal_selesai',
                'users.name'
            )
            ->when($request->has('date_range'), function ($query) use ($date_start, $date_end) {
                $query->whereBetween('daily_activity_h.tanggal', [$date_start, $date_end]);
            })
            ->where('daily_activity_h.id_user', Auth::id())
            ->orderBy('daily_activity_h.tanggal', 'desc')
            ->get();

        // Preload semua area untuk mengurangi queries
        $allAreas = $data->pluck('area_group_depo')
            ->filter()
            ->flatMap(function ($area) {
                return explode(", ", str_replace("'", "", $area ?? ''));
            })
            ->unique()
            ->values();

        // Preload semua depo data sekaligus
        $allDepoData = [];
        if (!empty($allAreas)) {
            $allDepoData = DB::table('daily_activity_d')
                ->join('depos', 'daily_activity_d.depo', '=', 'depos.kode_depo')
                ->whereIn('daily_activity_d.depo', $allAreas)
                ->get()
                ->groupBy('tanggal');
        }

        $structuredData = [];

        foreach ($data as $val) {
            $area = explode(", ", str_replace("'", "", $val->area_group_depo ?? ''));
            
            // Gunakan data yang sudah di-preload
            $data_ssd = isset($allDepoData[$val->tanggal]) 
                ? $allDepoData[$val->tanggal]->filter(function ($item) use ($area) {
                    return in_array($item->depo, $area);
                })->map(function ($item) {
                    // Konversi object ke array untuk konsistensi
                    return [
                        'id' => $item->id,
                        'depo' => $item->depo,
                        'tanggal' => $item->tanggal,
                        'challenge' => $item->challenge,
                        'instruksi' => $item->instruksi,
                        'catatan' => $item->catatan,
                        'status' => $item->status,
                        'tanggal_selesai' => $item->tanggal_selesai,
                        'nama_depo' => $item->nama_depo,
                        'kode_depo' => $item->kode_depo
                    ];
                })->values()->toArray()
                : [];

            $structuredActivity = [
                'id' => $val->id,
                'name' => $val->name,
                'jabatan' => $val->jabatan,
                'tanggal' => $val->tanggal,
                'instruksi' => $val->instruksi,
                'area_group_depo' => $val->area_group_depo,
                'area_name' => $val->area_name,
                'status' => $val->status,
                'tanggal_selesai' => $val->tanggal_selesai,
                'depo' => !empty($data_ssd) ? $data_ssd : null,
            ];

            $structuredData[] = $structuredActivity;
        }

        $data_users = DB::table('users')
            ->leftJoin('divisi_sub', 'users.kode_sub_divisi', '=', 'divisi_sub.kode_divisi_sub')
            ->select('users.id as id_user', 'divisi_sub.nama_divisi_sub')
            ->where('users.id', Auth::id())
            ->first();

        $area = DB::table('dt_area')->orderBy('id')->get();

        return view('daily_activity_som.list', compact('structuredData', 'data', 'data_users', 'area'));
    }

    public function cari(Request $request)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data = DB::table('daily_activity')
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
            ->where('daily_activity.id_user', Auth::user()->id)
            ->get();

            return view ('daily_activity_som.list', compact('data'));
    }

    public function view($id)
    {
        $data_view = DB::table('daily_activity_h')
                ->join('users','daily_activity_h.id_user','=','users.id')
                ->join('depos','daily_activity_h.depo','=','depos.kode_depo')
                ->Where('daily_activity_h.id', $id)
                ->first();

        return view ('daily_activity_som.view', compact('data_view'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
    }

    public function modalDetail(Request $request)
    {
        $id = $request->id;
        $type = $request->type; // 'main' atau 'depo'

        if ($type === 'depo') {
            // Handle modal untuk data depo
            $data = DB::table('daily_activity_d')
                    ->where('id', $id)
                    ->first();

            return response()->json([
                'type' => 'depo',
                'data' => $data
            ]);
        } else {
            // Handle modal untuk data utama (existing code)
            $header = DB::table('daily_activity_h as h')
                ->join('dt_area as d', 'h.area', '=', 'd.id')
                ->select(
                    'h.id',
                    'h.tanggal',
                    'h.instruksi',
                    'h.status',
                    'h.tanggal_selesai',
                    'h.catatan',
                    'd.area_name',
                    'd.area_group_depo'
                )
                ->where('h.id', $id)
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
}
