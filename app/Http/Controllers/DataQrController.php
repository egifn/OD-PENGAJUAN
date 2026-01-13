<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Validator;
use App\Perusahaan;
use App\Divisi;
use App\QrData;
use App\QrData_Head;
use App\QrData_Detail;
use Carbon\carbon;
use PDF;
use DB;



class DataQrController extends Controller
{
    public function index()
    {
    	//$qr_data = QrData::all();

    	// $qr_data = DB::table('qr_data')
        //                ->leftJoin('perusahaans','qr_data.kode_perusahaan','=','perusahaans.kode_perusahaan')
        //                ->leftJoin('depos','qr_data.kode_depo','=','depos.kode_depo')
        //                ->select('qr_data.id','perusahaans.nama_perusahaan','depos.nama_depo','qr_data.kode_spv','qr_data.nama','qr_data.telepon','qr_data.alamat','qr_data.koordinat_lintang','qr_data.koordinat_bujur','qr_data.biaya_sewa','qr_data.jenis','qr_data.status')
        //                ->get();
        //    return view ('qr_code.index', compact('qr_data'));

       
        date_default_timezone_set('Asia/Jakarta');

        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $qr_data = DB::table('qr_data_head')
                    ->Join('perusahaans','qr_data_head.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->Join('qr_data_detail','qr_data_head.kode','=','qr_data_detail.kode')
                    ->select('qr_data_head.kode','qr_data_head.kode_perusahaan','perusahaans.nama_perusahaan',DB::raw('count(qr_data_detail.id) as jml'),'qr_data_head.tanggal')
                    ->WhereBetween('qr_data_head.tanggal', [$date_start,$date_end])
                    ->groupBy('qr_data_head.kode','qr_data_head.kode_perusahaan','perusahaans.nama_perusahaan','qr_data_head.tanggal')
                    ->get();
        return view ('qr_code.master_qr.index', compact('qr_data'));


    }

    public function cari(Request $request)
    {
        
        date_default_timezone_set('Asia/Jakarta');
        
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $qr_data = DB::table('qr_data_head')
                    ->Join('perusahaans','qr_data_head.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->Join('qr_data_detail','qr_data_head.kode','=','qr_data_detail.kode')
                    ->select('qr_data_head.kode','qr_data_head.kode_perusahaan','perusahaans.nama_perusahaan',DB::raw('count(qr_data_detail.id) as jml'),'qr_data_head.tanggal')
                    ->WhereBetween('qr_data_head.tanggal', [$date_start,$date_end])
                    ->groupBy('qr_data_head.kode','qr_data_head.kode_perusahaan','perusahaans.nama_perusahaan','qr_data_head.tanggal')
                    ->get();
        return view ('qr_code.master_qr.index', compact('qr_data'));
    }

    public function create(Request $request)
    {

        //$getRow = QrData::orderBy('id', 'DESC')->get();
        $getRow = QrData_head::orderBy('kode', 'DESC')->get();
        $rowCount = $getRow->count();

        $kode = "000001";
        if ($rowCount > 0) {
                if ($rowCount < 9) {
                    $kode = "00000".''.($rowCount + 1);
                } else if ($rowCount < 99) {
                    $kode = "0000".''.($rowCount + 1);
                } else if ($rowCount < 999) {
                    $kode = "000".''.($rowCount + 1);
                } else if ($rowCount < 9999) {
                    $kode = "00".''.($rowCount + 1);
                } else {
                    $kode = "0".''.($rowCount + 1);
                }
        }

        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get(); 

        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
        $kode_divisi = $request->get('1');
        $divisi_sub = DB::table('divisi_sub')->where('kode_divisi', $kode_divisi)->orderBy('kode_divisi_sub')->get();

        return view ('qr_code.create',compact('perusahaan','depo','divisi','kode'));
    }

    public function view($kode)
    {
        $qr_data_view = DB::table('qr_data_head')
                    ->Join('qr_data_detail','qr_data_head.kode','=','qr_data_detail.kode')
                    ->Join('qr_data','qr_data_detail.id','=','qr_data.id')
                    ->Join('perusahaans','qr_data.kode_perusahaan','perusahaans.kode_perusahaan')
                    ->leftJoin('depos','qr_data.kode_depo','=','depos.kode_depo')
                    ->select('qr_data_head.kode','qr_data_detail.id','perusahaans.nama_perusahaan','depos.nama_depo','qr_data.kode_spv','qr_data.nama','qr_data.alamat','qr_data.koordinat_lintang','qr_data.koordinat_bujur','qr_data.telepon','qr_data.biaya_sewa','qr_data.jenis')
                    ->where('qr_data_head.kode', $kode)
                    ->get();
        return view ('qr_code.index', compact('qr_data_view'));
    }

    public function update(Request $request, $id)
    {   
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $kode_perusahaan = $request->get('1');
        // $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get();
        $depo = DB::table('depos')->orderBy('kode_depo', 'ASC')->get();

        $data = DB::table('qr_data')
                    ->leftJoin('perusahaans','qr_data.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->leftJoin('depos','qr_data.kode_depo','=','depos.kode_depo')
                    ->select('qr_data.id','qr_data.kode_perusahaan','perusahaans.nama_perusahaan','qr_data.kode_spv','qr_data.kode_depo','depos.nama_depo','qr_data.nama','qr_data.alamat','qr_data.telepon','qr_data.koordinat_lintang','qr_data.koordinat_bujur','qr_data.biaya_sewa','qr_data.jenis','qr_data.status')
                    ->where('qr_data.id', $id)
                    ->first();


        return view ('qr_code.update',compact('perusahaan','depo','data'));
    }

    public function store(Request $request)
    {
        $getRow_kode = QrData_Head::orderBy('kode', 'DESC')->get();
        $rowCount_kode = $getRow_kode->count();
        $kode_temp = "000001";
        if ($rowCount_kode > 0) {
            if ($rowCount_kode < 9) {
                $kode_temp = "00000".''.($rowCount_kode + 1);
            } else if ($rowCount_kode < 99) {
                $kode_temp = "0000".''.($rowCount_kode + 1);
            } else if ($rowCount_kode < 999) {
                $kode_temp = "000".''.($rowCount_kode + 1);
            } else if ($rowCount_kode < 9999) {
                $kode_temp = "00".''.($rowCount_kode + 1);
            } else {
                $kode_temp = "0".''.($rowCount_kode + 1);
            }
        }

        QrData_Head::create([
            'kode' => $kode_temp,
            'kode_perusahaan' => $request->get('kode_perusahaan_head'),
            'tanggal' => Carbon::now()->format('Y-m-d')
        ]);


        $datas=[];
        foreach ($request->input('kode_id') as $key => $value) {
            // $datas["kode_cek.{$key}"] = 'required'; 
            // $datas["no_cek.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input("kode_id") as $key => $value) {

                $getRow = QrData::where('kode_perusahaan', $request->kode_perusahaan)->orderBy('id', 'DESC')->get();
                $rowCount = $getRow->count();

                $kode = $request->get("kode_perusahaan")[$key].''."000001";
                if ($rowCount > 0) {
                    if ($rowCount < 9) {
                        $kode = $request->get("kode_perusahaan")[$key].''."00000".''.($rowCount + 1);
                    } else if ($rowCount < 99) {
                        $kode = $request->get("kode_perusahaan")[$key].''."0000".''.($rowCount + 1);
                    } else if ($rowCount < 999) {
                        $kode = $request->get("kode_perusahaan")[$key].''."000".''.($rowCount + 1);
                    } else if ($rowCount < 9999) {
                        $kode = $request->get("kode_perusahaan")[$key].''."00".''.($rowCount + 1);
                    } else {
                        $kode = $request->get("kode_perusahaan")[$key].''."0".''.($rowCount + 1);
                    }
                }


                $data = new QrData;

                $data->id = $kode;
                $data->kode_perusahaan = $request->get("kode_perusahaan")[$key];
                $data->kode_depo = '';
                $data->kode_spv = '';
                $data->nama = '';
                $data->telepon = '';
                $data->alamat = '';
                $data->koordinat_lintang = '';
                $data->koordinat_bujur = '';
                $data->biaya_sewa = '0';
                $data->jenis = '';
                $data->status = '';
                $data->save();

                $data_detail = new QrData_Detail;
                $data_detail->kode = $kode_temp;
                $data_detail->id = $kode;
                $data_detail->save();
            }
        }

        return redirect(route('qr_code.index'))->with(['success']);
          //return redirect(route('qr_code.create'))->with(['success']);
    }

    public function edit(Request $request)
    {
        $update_qr = QrData::find($request->get('kode_id'));
        $update_qr->update([
            'kode_depo' => $request->get("kode_depo"),
            'kode_spv' => $request->get("spv"),
            'nama' => $request->get("nama_toko"),
            'telepon' => $request->get("telepon"),
            'alamat' => $request->get("alamat"),
            'koordinat_lintang' => $request->get("koordinat_1"),
            'koordinat_bujur' => $request->get("koordinat_2"),
            'biaya_sewa' => $request->get("biaya_sewa"),
            'jenis' => $request->get("jenis"),
            'status' => '1'
        ]);

        return redirect(route('qr_code.view', "000001"))->with(['success' => 'Data Qr berhasil diubah']);
    }

    public function generate($id)
    {
        $qr_data = QrData::findOrFail($id);
        // $qr_data = DB::table('qr_data')
     //                ->leftJoin('perusahaans','qr_data.kode_perusahaan','=','perusahaans.kode_perusahaan')
     //                ->leftJoin('depos','qr_data.kode_depo','=','depos.kode_depo')
     //                ->select('qr_data.id','perusahaans.nama_perusahaan','depos.nama_depo','qr_data.nama')
     //                ->Where('qr_data.id', $id)
     //                ->get();
       

        $qr_code = QrCode::size(100)
                    ->generate($qr_data->id);
        return view('qr_code.view',compact('qr_code','qr_data'));   
    }

    public function pdf($kode)
    {
         
        // $qr_data = DB::table('qr_data')
        //             ->leftJoin('perusahaans','qr_data.kode_perusahaan','=','perusahaans.kode_perusahaan')
        //             ->leftJoin('depos','qr_data.kode_depo','=','depos.kode_depo')
        //             ->select('qr_data.id','perusahaans.nama_perusahaan','depos.nama_depo','qr_data.nama')
        //             ->get();

        $qr_data = DB::table('qr_data_head')
                    ->Join('qr_data_detail','qr_data_head.kode','=','qr_data_detail.kode')
                    ->select('qr_data_head.kode','qr_data_head.kode_perusahaan','qr_data_detail.id')
                    ->where('qr_data_head.kode', $kode)
                    ->get();
        
        $pdf = PDF::loadview('qr_code.pdf', compact('qr_data'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
