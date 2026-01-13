<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class UangRitController extends Controller
{
    public function index()
    {
        return view('logistik.index');
    }

    public function getDataUangRit(Request $request)
    {
        $data_uang_rit = DB::table('ms_uang_rit');

        if (!isset($request->value)) {
        } else {
            //$data_uang_rit->where('ms_uang_rit.nama_toko', 'like', "%$request->value%");
        }

        $data  = $data_uang_rit->get();
        $count = ($data_uang_rit->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function getData(Request $request)
    {
        // Mendapatkan data dari tabel 'ms_uang_rit' berdasarkan kode yang diberikan
        $dataDetail = DB::table('ms_uang_rit')
            ->where('ms_uang_rit.kode', $request->id)
            ->first();

        // Mendapatkan semua data dari tabel 'dt_product'
        $produk = DB::table('dt_product')->get();

        // Menggabungkan hasil kedua query dalam satu output
        $output = [
            'status'  => true,
            'message' => 'success',
            'dataDetail' => $dataDetail,
            'produk' => $produk
        ];

        return response()->json($output, 200);
    }


    public function store(Request $request)
    {
        DB::table('ms_uang_rit')->insert([
            'kode' => $request->code,
            'sku' => $request->sku,
            'nama_toko' => $request->nama_toko,
            'area' => $request->area,
            'pabrik' => $request->pabrik,
            'qty' => $request->qty,
            'uang_rit' => str_replace(",", "", $request->uang_rit),
            'claim_tol' => $request->claim_tol,
            'revisi' => $request->revisi,
            'keterangan' => $request->keterangan,
            'tgl_berlaku' => $request->tgl_berlaku,
            'pic' => $request->pic,
            'id_user_input' => Auth::user()->id
        ]);

        $output = [
            'msg'  => 'Data Unit Berhasil Ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    }

    public function update(Request $request)
    {
        DB::table('ms_uang_rit')->where('kode', $request->code)->update([
            'sku' => $request->sku,
            'nama_toko' => $request->nama_toko,
            'area' => $request->area,
            'pabrik' => $request->pabrik,
            'qty' => $request->qty,
            'uang_rit' => str_replace(",", "", $request->uang_rit),
            'claim_tol' => $request->claim_tol,
            'revisi' => $request->revisi,
            'keterangan' => $request->keterangan,
            'tgl_berlaku' => $request->tgl_berlaku,
            'pic' => $request->pic
        ]);

        $output = [
            'message'  => 'Data Berhasil Diubah',
            'status'  => true,
        ];
        return response()->json($output, 200);
    }

    public function getDataProduk(Request $request)
    {

        // dd($request);
        $query = $request->input('q');
        $products = DB::table('dt_product')
            ->select('id', 'product_name')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('product_name', 'like', '%' . $query . '%');
            })
            ->get();

        return response()->json([
            'status' => true,
            'data' => $products,
            'keyword' => $query
        ]);
    }

    // Data Dropdown Toko
    public function getDataDestinasi()
    {
        // $query = $request->input('q');

        // Ambil tanggal satu minggu yang lalu
        $recentlyCreatedLimit = 1;
        $oneWeekAgo = Carbon::now()->subWeek();

        $customerstua = DB::connection('mysql_tua')
            ->table('dms_ar_customer')
            ->select('szName', 'dtmCreated') // Perbaikan format select
            ->whereDate('dtmCreated', '>=', $oneWeekAgo) // Filter data yang dibuat dalam satu minggu terakhir
            ->orderBy('dtmCreated', 'desc')
            ->limit($recentlyCreatedLimit)
            ->get();

        $branchestua = DB::connection('mysql_tua')
            ->table('dms_sm_branch')
            ->select('szName', 'dtmCreated') // Perbaikan format select
            ->whereDate('dtmCreated', '>=', $oneWeekAgo) // Filter data yang dibuat dalam satu minggu terakhir
            ->orderBy('dtmCreated', 'desc')
            ->limit($recentlyCreatedLimit)
            ->get();

        $customerstu = DB::connection('mysql_tu')
            ->table('dms_ar_customer')
            ->select('szName', 'dtmCreated') // Perbaikan format select
            ->whereDate('dtmCreated', '>=', $oneWeekAgo) // Filter data yang dibuat dalam satu minggu terakhir
            ->orderBy('dtmCreated', 'desc')
            ->limit($recentlyCreatedLimit)
            ->get();

        $branchestu = DB::connection('mysql_tu')
            ->table('dms_sm_branch')
            ->select('szName', 'dtmCreated') // Perbaikan format select
            ->whereDate('dtmCreated', '>=', $oneWeekAgo) // Filter data yang dibuat dalam satu minggu terakhir
            ->orderBy('dtmCreated', 'desc')
            ->limit($recentlyCreatedLimit)
            ->get();

        $customersta = DB::connection('mysql_ta')
            ->table('dms_ar_customer')
            ->select('szName', 'dtmCreated') // Perbaikan format select
            ->whereDate('dtmCreated', '>=', $oneWeekAgo) // Filter data yang dibuat dalam satu minggu terakhir
            ->orderBy('dtmCreated', 'desc')
            ->limit($recentlyCreatedLimit)
            ->get();

        $branchesta = DB::connection('mysql_ta')
            ->table('dms_sm_branch')
            ->select('szName', 'dtmCreated') // Perbaikan format select
            ->whereDate('dtmCreated', '>=', $oneWeekAgo) // Filter data yang dibuat dalam satu minggu terakhir
            ->orderBy('dtmCreated', 'desc')
            ->limit($recentlyCreatedLimit)
            ->get();


        $dataGabungan = $customerstua->merge($branchestua)
            ->merge($customerstu)
            ->merge($branchestu)
            ->merge($customersta)
            ->merge($branchesta);

        return response()->json([
            'status' => true,
            'data' => $dataGabungan,
        ]);
    }

    public function getDataPabrik(Request $request)
    {
        $query = $request->input('q');

        $customerstua = DB::connection('mysql_tua')
            ->table('dms_ap_supplier')
            ->select('szName', 'dtmCreated')
            ->orderBy('szName', 'asc')
            ->get();

        $branchestua = DB::connection('mysql_tua')
            ->table('dms_sm_branch')
            ->select('szName', 'dtmCreated')
            ->orderBy('szName', 'asc')
            ->get();

        $customerstu = DB::connection('mysql_tu')
            ->table('dms_ap_supplier')
            ->select('szName', 'dtmCreated')
            ->orderBy('szName', 'asc')
            ->get();

        $branchestu = DB::connection('mysql_tu')
            ->table('dms_sm_branch')
            ->select('szName', 'dtmCreated')
            ->orderBy('szName', 'asc')
            ->get();

        $customersta = DB::connection('mysql_ta')
            ->table('dms_ap_supplier')
            ->select('szName', 'dtmCreated')
            ->orderBy('szName', 'asc')
            ->get();

        $branchesta = DB::connection('mysql_ta')
            ->table('dms_sm_branch')
            ->select('szName', 'dtmCreated')
            ->orderBy('szName', 'asc')
            ->get();


        $dataGabungan = $customerstua->merge($branchestua)
            ->merge($customerstu)
            ->merge($branchestu)
            ->merge($customersta)
            ->merge($branchesta);

        return response()->json([
            'status' => true,
            'data' => $dataGabungan,
        ]);
    }
}
