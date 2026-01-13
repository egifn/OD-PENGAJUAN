<?php

namespace App\Http\Controllers\Hrd\Remun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Perusahaan;
use Carbon\carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RemunController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_divisi == '1'){
            $data_remun = DB::table('remunerasi_head')
                        ->select(
                            'remunerasi_head.no_urut',
                            'remunerasi_head.tgl_remun',
                            'remunerasi_head.no_ptk',
                            'remunerasi_head.id_finger',
                            'remunerasi_head.id_dms',
                            'remunerasi_head.nama',
                            'remunerasi_head.jabatan',
                            'remunerasi_head.depo',
                            'remunerasi_head.pencairan',
                            'remunerasi_head.status_atasan',
                            'remunerasi_head.status_biaya_pusat',
                            'remunerasi_head.status_biaya_pusat_koor'
                        )
                        ->WhereBetween('remunerasi_head.tgl_remun', [$date_start,$date_end])
                        ->orderBy('remunerasi_head.tgl_remun', 'ASC')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '6'){
            if(Auth::user()->kode_sub_divisi == '5'){ 
                $data_remun = DB::table('remunerasi_head')
                        ->select(
                            'remunerasi_head.no_urut',
                            'remunerasi_head.tgl_remun',
                            'remunerasi_head.no_ptk',
                            'remunerasi_head.id_finger',
                            'remunerasi_head.id_dms',
                            'remunerasi_head.nama',
                            'remunerasi_head.jabatan',
                            'remunerasi_head.depo',
                            'remunerasi_head.pencairan',
                            'remunerasi_head.status_atasan',
                            'remunerasi_head.status_biaya_pusat',
                            'remunerasi_head.status_biaya_pusat_koor'
                        )
                        ->WhereBetween('remunerasi_head.tgl_remun', [$date_start,$date_end])
                        ->where('remunerasi_head.status_atasan', '1')
                        ->orderBy('remunerasi_head.tgl_remun', 'ASC')
                        ->get();
            }elseif(Auth::user()->kode_sub_divisi == '4'){
                $data_remun = DB::table('remunerasi_head')
                        ->select(
                            'remunerasi_head.no_urut',
                            'remunerasi_head.tgl_remun',
                            'remunerasi_head.no_ptk',
                            'remunerasi_head.id_finger',
                            'remunerasi_head.id_dms',
                            'remunerasi_head.nama',
                            'remunerasi_head.jabatan',
                            'remunerasi_head.depo',
                            'remunerasi_head.pencairan',
                            'remunerasi_head.status_atasan',
                            'remunerasi_head.status_biaya_pusat',
                            'remunerasi_head.status_biaya_pusat_koor'
                        )
                        ->WhereBetween('remunerasi_head.tgl_remun', [$date_start,$date_end])
                        ->where('remunerasi_head.status_biaya_pusat', '1')
                        ->orderBy('remunerasi_head.tgl_remun', 'ASC')
                        ->get();
            }
        }
        return view('hrd.remun.index', compact('data_remun'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_divisi == '1'){
            $data_remun = DB::table('remunerasi_head')
                        ->select(
                            'remunerasi_head.no_urut',
                            'remunerasi_head.tgl_remun',
                            'remunerasi_head.no_ptk',
                            'remunerasi_head.id_finger',
                            'remunerasi_head.id_dms',
                            'remunerasi_head.nama',
                            'remunerasi_head.jabatan',
                            'remunerasi_head.depo',
                            'remunerasi_head.pencairan',
                            'remunerasi_head.status_atasan',
                            'remunerasi_head.status_biaya_pusat',
                            'remunerasi_head.status_biaya_pusat_koor'
                        )
                        ->WhereBetween('remunerasi_head.tgl_remun', [$date_start,$date_end])
                        ->orderBy('remunerasi_head.tgl_remun', 'ASC')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '6'){
            if(Auth::user()->kode_sub_divisi == '5'){ 
                $data_remun = DB::table('remunerasi_head')
                        ->select(
                            'remunerasi_head.no_urut',
                            'remunerasi_head.tgl_remun',
                            'remunerasi_head.no_ptk',
                            'remunerasi_head.id_finger',
                            'remunerasi_head.id_dms',
                            'remunerasi_head.nama',
                            'remunerasi_head.jabatan',
                            'remunerasi_head.depo',
                            'remunerasi_head.pencairan',
                            'remunerasi_head.status_atasan',
                            'remunerasi_head.status_biaya_pusat',
                            'remunerasi_head.status_biaya_pusat_koor'
                        )
                        ->WhereBetween('remunerasi_head.tgl_remun', [$date_start,$date_end])
                        ->where('remunerasi_head.status_atasan', '1')
                        ->orderBy('remunerasi_head.tgl_remun', 'ASC')
                        ->get();
            }elseif(Auth::user()->kode_sub_divisi == '4'){
                $data_remun = DB::table('remunerasi_head')
                        ->select(
                            'remunerasi_head.no_urut',
                            'remunerasi_head.tgl_remun',
                            'remunerasi_head.no_ptk',
                            'remunerasi_head.id_finger',
                            'remunerasi_head.id_dms',
                            'remunerasi_head.nama',
                            'remunerasi_head.jabatan',
                            'remunerasi_head.depo',
                            'remunerasi_head.pencairan',
                            'remunerasi_head.status_atasan',
                            'remunerasi_head.status_biaya_pusat',
                            'remunerasi_head.status_biaya_pusat_koor'
                        )
                        ->WhereBetween('remunerasi_head.tgl_remun', [$date_start,$date_end])
                        ->where('remunerasi_head.status_biaya_pusat', '1')
                        ->orderBy('remunerasi_head.tgl_remun', 'ASC')
                        ->get();
            }
        }

        return view('hrd.remun.index', compact('data_remun'));
    }

    public function create(Request $request)
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        return view('hrd.remun.create', compact('perusahaan'));
    }

    public function actionKaryawan(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            
            $data = DB::table('ms_data_karyawan')
                            ->Join('perusahaans','ms_data_karyawan.perusahaan','=','perusahaans.kode_perusahaan')
                            ->Join('depos','ms_data_karyawan.depo','=','depos.kode_depo')
                            ->leftJoin('dt_area','ms_data_karyawan.area','=','dt_area.id')
                            ->select('ms_data_karyawan.id','ms_data_karyawan.nama','ms_data_karyawan.nik','ms_data_karyawan.id_dms',
                                    'ms_data_karyawan.perusahaan','perusahaans.nama_perusahaan','ms_data_karyawan.depo','depos.nama_depo',
                                    'ms_data_karyawan.jabatan','ms_data_karyawan.area','dt_area.area_name','ms_data_karyawan.tgl_gabung')
                            ->Where('ms_data_karyawan.nama','like','%'.$query.'%')
                            ->orWhere('ms_data_karyawan.perusahaan','like','%'.$query.'%')
                            ->orWhere('perusahaans.nama_perusahaan','like','%'.$query.'%')
                            ->orWhere('depos.nama_depo','like','%'.$query.'%')
                            ->get();
            
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_karyawan" data-id="'.$row->id.'" data-nama="'.$row->nama.'" data-nik="'.$row->nik.'" data-id_dms="'.$row->id_dms.'" data-jabatan="'.$row->jabatan.'" data-kode_perusahaan="'.$row->perusahaan.'" data-nama_perusahaan="'.$row->nama_perusahaan.'" data-depo="'.$row->depo.'" data-nama_depo="'.$row->nama_depo.'" data-area="'.$row->area.'" data-nama_area="'.$row->area_name.'" data-tgl="'.$row->tgl_gabung.'">
                            <td>'.$row->id.'</td>
                            <td>'.$row->nama.'</td>
                            <td>'.$row->nik.'</td>
                            <td>'.$row->id_dms.'</td>
                            <td>'.$row->jabatan.'</td>
                            <td>'.$row->perusahaan.'</td>
                            <td hidden>'.$row->nama_perusahaan.'</td>
                            <td hidden>'.$row->depo.'</td>
                            <td>'.$row->nama_depo.'</td>
                            <td hidden>'.$row->area.'</td>
                            <td>'.$row->area_name.'</td>
                            <td hidden>'.$row->tgl_gabung.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function actionTunjangan(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            
            $data = DB::table('ms_data_tunjangan')
                            ->select('ms_data_tunjangan.id','ms_data_tunjangan.nama_tunjangan','ms_data_tunjangan.nilai')
                            ->Where('ms_data_tunjangan.nama_tunjangan','like','%'.$query.'%')
                            ->get();
            
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_tunjangan" data-id="'.$row->id.'" data-nama_tun="'.$row->nama_tunjangan.'" data-nilai="'.$row->nilai.'">
                            <td>'.$row->id.'</td>
                            <td>'.$row->nama_tunjangan.'</td>
                            <td>'.$row->nilai.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        // simpan header (data utama)
        $rowCount = DB::table('remunerasi_head')
                ->select(DB::raw('COUNT(no_urut) as NoUrut'))
                ->first();
        if($rowCount->NoUrut > 0){
            $no_urut = $rowCount->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        DB::table('remunerasi_head')->insert([
            'no_urut'    => $no_urut,
            'no_ptk'     => $request->no_ptk,
            'tgl_remun'  => Carbon::now()->format('Y-m-d'),
            'id_finger'  => $request->id_finger,
            'id_dms'     => $request->id_dms,
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'depo'       => $request->lokasi,
            'area'       => $request->base,
            'tgl_masuk'  => $request->tgl_masuk,
            'jenis_remun' => $request->jenis_remun,
            'tgl_berlaku' => $request->tgl_berlaku,
            'tgl_periode_dari' => $request->periode_dari,
            'tgl_periode_sampai' => $request->periode_sampai,
            'pencairan' => $request->pencairan,
            'id_user_input' => Auth::user()->id,
        ]);

        // simpan detail tunjangan
        $kode_tunjangan = $request->kode_tunjangan;
        $nilai          = $request->nilai;

        if ($kode_tunjangan) {
            foreach ($kode_tunjangan as $i => $kode) {
                DB::table('remunerasi_detail')->insert([
                    'no_urut'      => $no_urut,
                    'no_ptk'       => $request->no_ptk,
                    'id_tunjangan' => $kode_tunjangan[$i],
                    'nilai'          => $nilai[$i],
                ]);
            }
        }

        return redirect()->route('remun/index.index')->with('success', 'Data Remunerasi berhasil disimpan');
        
    }

    public function view($no_ptk)
    {
        $data_remun_head = DB::table('remunerasi_head')
                        ->select('remunerasi_head.id','remunerasi_head.no_urut','remunerasi_head.no_ptk','remunerasi_head.tgl_remun','remunerasi_head.id_finger',
                        'remunerasi_head.id_dms','remunerasi_head.nama','remunerasi_head.jabatan','remunerasi_head.depo','remunerasi_head.area',
                        'remunerasi_head.tgl_masuk','remunerasi_head.jenis_remun','remunerasi_head.tgl_berlaku','remunerasi_head.tgl_periode_dari','remunerasi_head.tgl_periode_sampai',
                        'remunerasi_head.pencairan',
                        'remunerasi_head.status_atasan',
                        'remunerasi_head.status_biaya_pusat',
                        'remunerasi_head.status_biaya_pusat_koor')
                        ->where('remunerasi_head.no_urut', $no_ptk)->first();

        $data_remun_detail = DB::table('remunerasi_detail')
                        ->join('ms_data_tunjangan','remunerasi_detail.id_tunjangan','=','ms_data_tunjangan.id')
                        ->select('remunerasi_detail.no_urut','remunerasi_detail.no_ptk','remunerasi_detail.id_tunjangan','ms_data_tunjangan.nama_tunjangan','remunerasi_detail.nilai')
                        ->where('remunerasi_detail.no_urut', $no_ptk)->get();

        $total = DB::table('remunerasi_detail')
            ->select(DB::raw('SUM(remunerasi_detail.nilai) as total'))
            ->where('remunerasi_detail.no_urut', $no_ptk)
            ->first();

        return view('hrd.remun.view', compact('data_remun_head','data_remun_detail','total'));
    }

    public function approved(Request $request)
    {
        $tahun = (date('Y'));
        $bulan = (date('m'));

        if ($bulan == '01'){
            $bulan_romawi = 'I'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
        }

        if(Auth::user()->kode_divisi == '1'){
            $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $no_app = 'APP '.'1'.'/'.'TUA'.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;

            $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                        ->update([
                            'status_atasan' => 1,
                            'id_user_atasan' => Auth::user()->id,
                            'tgl_app_atasan' => Carbon::now()->format('Y-m-d'),
                            'kode_app_atasan' => $no_app
                        ]);

            $output = [
                        'msg'  => 'Transaksi baru berhasil diupdate',
                        'res'  => true,
                        'type' => 'success'
                    ];
                    return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '6'){
            if(Auth::user()->kode_sub_divisi == '5'){ 
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $no_app = 'APP '.'1'.'/'.'TUA'.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;

                $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                            ->update([
                                'status_biaya_pusat' => 1,
                                'id_user_biaya_pusat' => Auth::user()->id,
                                'tgl_app_biaya_pusat' => Carbon::now()->format('Y-m-d'),
                                'kode_app_biaya_pusat' => $no_app
                            ]);

                $output = [
                            'msg'  => 'Transaksi baru berhasil diupdate',
                            'res'  => true,
                            'type' => 'success'
                        ];
                        return response()->json($output, 200);
            }elseif(Auth::user()->kode_sub_divisi == '4'){
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $no_app = 'APP '.'1'.'/'.'TUA'.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;

                $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                            ->update([
                                'status_biaya_pusat_koor' => 1,
                                'id_user_biaya_pusat_koor' => Auth::user()->id,
                                'tgl_app_biaya_pusat_koor' => Carbon::now()->format('Y-m-d'),
                                'kode_app_biaya_pusat_koor' => $no_app
                            ]);

                $output = [
                            'msg'  => 'Transaksi baru berhasil diupdate',
                            'res'  => true,
                            'type' => 'success'
                        ];
                        return response()->json($output, 200);
            }
        }
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_divisi == '1'){
            $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                        ->update([
                            'status_atasan' => 2,
                            'id_user_atasan' => Auth::user()->id,
                            'tgl_app_atasan' => Carbon::now()->format('Y-m-d')
                        ]);

            $output = [
                        'msg'  => 'Transaksi baru berhasil diupdate',
                        'res'  => true,
                        'type' => 'success'
                    ];
                    return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '6'){
            if(Auth::user()->kode_sub_divisi == '5'){ 
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                            ->update([
                                'status_biaya_pusat' => 2,
                                'id_user_biaya_pusat' => Auth::user()->id,
                                'tgl_app_biaya_pusat' => Carbon::now()->format('Y-m-d')
                            ]);

                $output = [
                            'msg'  => 'Transaksi baru berhasil diupdate',
                            'res'  => true,
                            'type' => 'success'
                        ];
                        return response()->json($output, 200);
            }elseif(Auth::user()->kode_sub_divisi == '4'){
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                            ->update([
                                'status_biaya_pusat_koor' => 2,
                                'id_user_biaya_pusat_koor' => Auth::user()->id,
                                'tgl_app_biaya_pusat_koor' => Carbon::now()->format('Y-m-d')
                            ]);

                $output = [
                            'msg'  => 'Transaksi baru berhasil diupdate',
                            'res'  => true,
                            'type' => 'success'
                        ];
                        return response()->json($output, 200);
            }
        }
    }

    public function pending(Request $request)
    {
        if(Auth::user()->kode_divisi == '1'){
            $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                        ->update([
                            'status_atasan' => 3,
                            'id_user_atasan' => Auth::user()->id,
                            'tgl_app_atasan' => Carbon::now()->format('Y-m-d')
                        ]);

            $output = [
                        'msg'  => 'Transaksi baru berhasil diupdate',
                        'res'  => true,
                        'type' => 'success'
                    ];
                    return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '6'){
            if(Auth::user()->kode_sub_divisi == '5'){ 
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                            ->update([
                                'status_biaya_pusat' => 3,
                                'id_user_biaya_pusat' => Auth::user()->id,
                                'tgl_app_biaya_pusat' => Carbon::now()->format('Y-m-d')
                            ]);

                $output = [
                            'msg'  => 'Transaksi baru berhasil diupdate',
                            'res'  => true,
                            'type' => 'success'
                        ];
                        return response()->json($output, 200);
            }elseif(Auth::user()->kode_sub_divisi == '4'){
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $approved = DB::table('remunerasi_head')->where('no_urut', $request->no_urut)
                            ->update([
                                'status_biaya_pusat_koor' => 3,
                                'id_user_biaya_pusat_koor' => Auth::user()->id,
                                'tgl_app_biaya_pusat_koor' => Carbon::now()->format('Y-m-d')
                            ]);

                $output = [
                            'msg'  => 'Transaksi baru berhasil diupdate',
                            'res'  => true,
                            'type' => 'success'
                        ];
                        return response()->json($output, 200);
            }
        }
    }

    public function update(Request $request, $no_ptk)
    {
        $data_remun_head = DB::table('remunerasi_head')
                        ->select('remunerasi_head.id','remunerasi_head.no_urut','remunerasi_head.no_ptk','remunerasi_head.tgl_remun','remunerasi_head.id_finger',
                        'remunerasi_head.id_dms','remunerasi_head.nama','remunerasi_head.jabatan','remunerasi_head.depo','remunerasi_head.area',
                        'remunerasi_head.tgl_masuk','remunerasi_head.jenis_remun','remunerasi_head.tgl_berlaku','remunerasi_head.tgl_periode_dari','remunerasi_head.tgl_periode_sampai',
                        'remunerasi_head.pencairan',
                        'remunerasi_head.status_atasan',
                        'remunerasi_head.status_biaya_pusat',
                        'remunerasi_head.status_biaya_pusat_koor')
                        ->where('remunerasi_head.no_urut', $no_ptk)->first();

        $data_remun_detail = DB::table('remunerasi_detail')
                        ->join('ms_data_tunjangan','remunerasi_detail.id_tunjangan','=','ms_data_tunjangan.id')
                        ->select('remunerasi_detail.no_urut','remunerasi_detail.no_ptk','remunerasi_detail.id_tunjangan','ms_data_tunjangan.nama_tunjangan','remunerasi_detail.nilai')
                        ->where('remunerasi_detail.no_urut', $no_ptk)->get();

        $total = DB::table('remunerasi_detail')
            ->select(DB::raw('SUM(remunerasi_detail.nilai) as total'))
            ->where('remunerasi_detail.no_urut', $no_ptk)
            ->first();

        return view('hrd.remun.edit', compact('data_remun_head','data_remun_detail','total'));
    }

    public function edit(Request $request)
    {
        DB::beginTransaction();
        try {
            // Ambil data dari request
            $no_urut        = $request->input('no_urut');
            $nama           = $request->input('nama');
            $id_finger      = $request->input('id_finger');
            $jabatan        = $request->input('jabatan');
            $id_dms         = $request->input('id_dms');
            $lokasi_kerja   = $request->input('lokasi');
            $tgl_masuk      = $request->input('tgl_masuk');
            $jenis_remun    = $request->input('jenis_remun');
            $tgl_berlaku    = $request->input('tgl_berlaku');
            $periode_dari   = $request->input('periode_dari');
            $periode_sampai = $request->input('periode_sampai');
            $pencairan      = $request->input('pencairan');

            // Update data di tabel remunerasi_head
            DB::table('remunerasi_head')
                ->where('no_urut', $no_urut)
                ->update([
                    'nama'                  => $nama,
                    'id_finger'             => $id_finger,
                    'jabatan'               => $jabatan,
                    'id_dms'                => $id_dms,
                    'depo'                  => $lokasi_kerja,
                    'tgl_masuk'             => $tgl_masuk,
                    'jenis_remun'           => $jenis_remun,
                    'tgl_berlaku'           => $jenis_remun == 'Remun tetap' ? $tgl_berlaku : null,
                    'tgl_periode_dari'      => $jenis_remun == 'Remun tidak tetap' ? $periode_dari : null,
                    'tgl_periode_sampai'    => $jenis_remun == 'Remun tidak tetap' ? $periode_sampai : null,
                    'pencairan'             => $pencairan,
                    'updated_at'            => now(),
                ]);

            // Hapus detail lama
            DB::table('remunerasi_detail')->where('no_urut', $no_urut)->delete();

            // Ambil input array dari form
            $kode_tunjangan = $request->input('kode_tunjangan', []);
            $nama_tunjangan = $request->input('nama_tunjangan', []);
            $nilai          = $request->input('nilai', []);
            
            // Simpan ulang detail baru
            foreach ($kode_tunjangan as $i => $kode) {
                if (!$kode) continue; // lewati jika kosong

                $nilai_bersih = preg_replace('/[^\d]/', '', $nilai[$i]) ?? 0; // hapus format Rp
                DB::table('remunerasi_detail')->insert([
                    'no_urut'        => $no_urut,
                    'id_tunjangan'   => $kode,
                    'nilai'          => $nilai_bersih,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('remun/index.index')->with('success', 'Data Remunerasi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }


    public function pdf($no_ptk)
    {
        $data_remun_head = DB::table('remunerasi_head')
                        ->select('remunerasi_head.id','remunerasi_head.no_urut','remunerasi_head.no_ptk','remunerasi_head.tgl_remun','remunerasi_head.id_finger',
                        'remunerasi_head.id_dms','remunerasi_head.nama','remunerasi_head.jabatan','remunerasi_head.depo','remunerasi_head.area',
                        'remunerasi_head.tgl_masuk','remunerasi_head.jenis_remun','remunerasi_head.tgl_berlaku','remunerasi_head.tgl_periode_dari','remunerasi_head.tgl_periode_sampai',
                        'remunerasi_head.id_user_input','users.name as hrd',
                        'remunerasi_head.id_user_atasan','ka_hrd.name as kahrd','remunerasi_head.kode_app_atasan','remunerasi_head.tgl_app_atasan',
                        'remunerasi_head.id_user_biaya_pusat','ka_biaya.name as kabiaya','remunerasi_head.kode_app_biaya_pusat','remunerasi_head.tgl_app_biaya_pusat',
                        'remunerasi_head.id_user_biaya_pusat_koor','ka_akunting.name as kaakunting','remunerasi_head.kode_app_biaya_pusat_koor','remunerasi_head.tgl_app_biaya_pusat_koor',)
                        ->leftJoin('users','remunerasi_head.id_user_input','=','users.id')
                        ->leftJoin('users as ka_hrd','remunerasi_head.id_user_atasan','=','ka_hrd.id')
                        ->leftJoin('users as ka_biaya','remunerasi_head.id_user_biaya_pusat','=','ka_biaya.id')
                        ->leftJoin('users as ka_akunting','remunerasi_head.id_user_biaya_pusat_koor','=','ka_akunting.id')
                        ->where('remunerasi_head.no_urut', $no_ptk)->first();

        $data_remun_detail = DB::table('remunerasi_detail')
                        ->join('ms_data_tunjangan','remunerasi_detail.id_tunjangan','=','ms_data_tunjangan.id')
                        ->select('remunerasi_detail.no_urut','remunerasi_detail.no_ptk','remunerasi_detail.id_tunjangan','ms_data_tunjangan.nama_tunjangan','remunerasi_detail.nilai')
                        ->where('remunerasi_detail.no_urut', $no_ptk)->get();

        $total = DB::table('remunerasi_detail')
            ->select(DB::raw('SUM(remunerasi_detail.nilai) as total'))
            ->where('remunerasi_detail.no_urut', $no_ptk)
            ->first();

        $pdf = PDF::loadview('hrd.remun.pdf', compact('data_remun_head','data_remun_detail','total'))->setPaper('a4', 'portrait');
        return $pdf->stream();

       
    }
}
