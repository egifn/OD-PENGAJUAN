<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Perusahaan;
use App\Izin_H_Detail;
use App\Izin_Pengajuan_Cek_Giro_d;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PengajuanCekGiroController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_pengajuan_cek = DB::table('izin_pengajuan_cek_giro_h')
            ->join('ms_pembawa_resi', 'izin_pengajuan_cek_giro_h.kode_pembawa_resi', '=', 'ms_pembawa_resi.id')
            ->join('users', 'izin_pengajuan_cek_giro_h.id_user_input', '=', 'users.id')
            ->join('izin_pengajuan_cek_giro_d', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
            ->select(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_terima_buku',
                'izin_pengajuan_cek_giro_h.keterangan',
                DB::raw("SUM(izin_pengajuan_cek_giro_d.banyak_buku) AS banyak_buku"),
                DB::raw("SUM(izin_pengajuan_cek_giro_d.sisa_banyak_buku) AS sisa_banyak_buku"),
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'users.name'
            )
            // ->WhereBetween('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', [$date_start,$date_end])
            ->groupBy(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_terima_buku',
                'izin_pengajuan_cek_giro_h.keterangan',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'users.name'
            )
            ->orderBy('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', 'DESC')
            ->get();

        $data_pengajuan_cek_terima = DB::table('izin_pengajuan_cek_giro_h')
            ->select(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.keterangan',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_h.id_penerima',
                'pengambil.pembawa_resi as pengambil_buku',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'izin_h.kode_terima_cek',
                'izin_h.tgl_izin AS tgl_terima',
                'users.name'
            )
            ->join('ms_pembawa_resi', 'izin_pengajuan_cek_giro_h.kode_pembawa_resi', '=', 'ms_pembawa_resi.id')
            ->join('users', 'izin_pengajuan_cek_giro_h.id_user_input', '=', 'users.id')
            ->join('izin_pengajuan_cek_giro_d', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
            ->leftJoin('izin_h', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_h.kode_pengajuan_cek')
            ->join('ms_pembawa_resi as pengambil', 'izin_h.id_penerima', '=', 'pengambil.id')
            ->whereBetween('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', [$date_start, $date_end])
            ->whereNotNull('izin_h.kode_terima_cek')
            ->groupBy(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.keterangan',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_h.id_penerima',
                'pengambil.pembawa_resi',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'izin_h.kode_terima_cek',
                'izin_h.tgl_izin',
                'users.name'
            )
            ->get();

        return view('finance.pengajuan_cek_giro.index', compact('data_pengajuan_cek', 'data_pengajuan_cek_terima'));
    }

    public function cari(Request $request)
    {
        if (request()->tanggal != '') {
            $date = explode(' - ', request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        } else {
            $date_start = (date('Y-m-d'));
            $date_end = (date('Y-m-d'));
        }

        $data_pengajuan_cek =  DB::table('izin_pengajuan_cek_giro_h')
            ->join('ms_pembawa_resi', 'izin_pengajuan_cek_giro_h.kode_pembawa_resi', '=', 'ms_pembawa_resi.id')
            ->join('users', 'izin_pengajuan_cek_giro_h.id_user_input', '=', 'users.id')
            ->join('izin_pengajuan_cek_giro_d', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
            ->select(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_terima_buku',
                'izin_pengajuan_cek_giro_h.keterangan',
                DB::raw("SUM(izin_pengajuan_cek_giro_d.banyak_buku) AS banyak_buku"),
                DB::raw("SUM(izin_pengajuan_cek_giro_d.sisa_banyak_buku) AS sisa_banyak_buku"),
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'users.name'
            )
            //->WhereBetween('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', [$date_start,$date_end])
            ->groupBy(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_terima_buku',
                'izin_pengajuan_cek_giro_h.keterangan',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'users.name'
            )
            ->orderBy('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', 'DESC')
            ->get();


        if (request()->tanggal_terima != '') {
            $date_terima = explode(' - ', request()->tanggal_terima);
            $date_start_terima = Carbon::parse($date_terima[0])->format('Y-m-d');
            $date_end_terima = Carbon::parse($date_terima[1])->format('Y-m-d');
        } else {
            $date_start_terima = (date('Y-m-d'));
            $date_end_terima = (date('Y-m-d'));
        }
        $data_pengajuan_cek_terima = DB::table('izin_pengajuan_cek_giro_h')
            ->select(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.keterangan',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_h.id_penerima',
                'pengambil.pembawa_resi as pengambil_buku',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'izin_h.kode_terima_cek',
                'izin_h.tgl_izin AS tgl_terima',
                'users.name'
            )
            ->join('ms_pembawa_resi', 'izin_pengajuan_cek_giro_h.kode_pembawa_resi', '=', 'ms_pembawa_resi.id')
            ->join('users', 'izin_pengajuan_cek_giro_h.id_user_input', '=', 'users.id')
            ->join('izin_pengajuan_cek_giro_d', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
            ->join('izin_h', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_h.kode_pengajuan_cek')
            ->join('ms_pembawa_resi as pengambil', 'izin_h.id_penerima', '=', 'pengambil.id')
            ->whereBetween('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', [$date_start_terima, $date_end_terima])
            ->whereNotNull('izin_h.kode_terima_cek')
            ->groupBy(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_pengajuan_cek_giro_h.keterangan',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_h.id_penerima',
                'pengambil.pembawa_resi',
                'izin_pengajuan_cek_giro_h.id_user_input',
                'izin_h.kode_terima_cek',
                'izin_h.tgl_izin',
                'users.name'
            )
            ->get();

        return view('finance.pengajuan_cek_giro.index', compact('data_pengajuan_cek', 'data_pengajuan_cek_terima'));
    }

    public function create(Request $request)
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'ASC')->get();
        // $pembawa_resi =

        return view('finance.pengajuan_cek_giro.create', compact('perusahaan'));
    }

    public function actionRek(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('rekening_fin_comp')
                    ->join('perusahaans', 'rekening_fin_comp.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
                    ->join('banks', 'rekening_fin_comp.kode_bank', '=', 'banks.kode_bank')
                    ->select('rekening_fin_comp.kode_perusahaan', 'perusahaans.nama_perusahaan', 'rekening_fin_comp.kode_bank', 'banks.nama_bank', 'rekening_fin_comp.norek', 'rekening_fin_comp.atas_nama_rek')
                    ->Where('rekening_fin_comp.norek', 'like', '%' . $query . '%')
                    ->orWhere('perusahaans.nama_perusahaan', 'like', '%' . $query . '%')
                    ->orWhere('banks.nama_bank', 'like', '%' . $query . '%')
                    ->get();
            } else {
                $data = DB::table('rekening_fin_comp')
                    ->join('perusahaans', 'rekening_fin_comp.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
                    ->join('banks', 'rekening_fin_comp.kode_bank', '=', 'banks.kode_bank')
                    ->select('rekening_fin_comp.kode_perusahaan', 'perusahaans.nama_perusahaan', 'rekening_fin_comp.kode_bank', 'banks.nama_bank', 'rekening_fin_comp.norek', 'rekening_fin_comp.atas_nama_rek')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_rek" data-kode="' . $row->kode_perusahaan . '" data-perusahaan="' . $row->nama_perusahaan . '" data-kode_bank="' . $row->kode_bank . '" data-bank="' . $row->nama_bank . '"  data-norek="' . $row->norek . '" data-an="' . $row->atas_nama_rek . '" >
                            <td hidden>' . $row->kode_perusahaan . '</td>
                            <td>' . $row->nama_perusahaan . '</td>
                            <td hidden>' . $row->kode_bank . '</td>
                            <td>' . $row->nama_bank . '</td>
                            <td>' . $row->norek . '</td>
                            <td>' . $row->atas_nama_rek . '</td>
                        </tr>
                    ';
                }
            } else {
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
        // Ambil data kode_pengajuan_cek terakhir dari database
        // $lastRecord = DB::table('izin_pengajuan_cek_giro_h')
        //     ->select('kode_pengajuan_cek')
        //     ->orderBy('kode_pengajuan_cek', 'desc')
        //     ->first();

        $tahun = date('y');
        $tanggal = date('d');
        $bulan = date('m');

        //$currentYear = now()->year;
        $tanggalPermintaan = $request->get('tgl_permintaan');
        $date = new \DateTime($tanggalPermintaan);
        $currentYear = $date->format('Y');
        $currentMonth = $date->format('m');
        $currentDay = $date->format('d');

        $getRow = DB::table('izin_pengajuan_cek_giro_h')
            ->select(DB::raw('COUNT(kode_pengajuan_cek) as NoUrut'))
            ->whereYear('tgl_pengajuan_cek', $currentYear);
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                $kode = 'REQ' . $currentDay . $currentMonth . $currentYear . '00' . '' . ($rowCount + 1);
            } else if ($rowCount < 99) {
                $kode = 'REQ' . $currentDay . $currentMonth . $currentYear . '0' . '' . ($rowCount + 1);
            } else if ($rowCount < 999) {
                $kode = 'REQ' . $currentDay . $currentMonth . $currentYear . '' . ($rowCount + 1);
            }
        } else {
            $kode = 'REQ' . $currentDay . $currentMonth . $currentYear . '001';
        }

        DB::table('izin_pengajuan_cek_giro_h')->insert([
            'kode_pengajuan_cek' => $kode,
            'tgl_pengajuan_cek' => $request->get('tgl_permintaan'), 
            'keterangan' => $request->get('keterangan'),
            'kode_pembawa_resi' => $request->get('kode_pembawa_resi'),
            'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('no_rek') as $key => $value) {
            
        }

        $validator = Validator::make($request->all(), $datas);
        foreach ($request->input('no_rek') as $key => $value) {
            $data = new Izin_Pengajuan_Cek_Giro_d();
            $data->kode_pengajuan_cek = $kode;
            $data->kode_perusahaan = $request->get("kode_perusahaan")[$key];
            $data->kode_bank = $request->get("kode_bank")[$key];
            $data->no_rekening = $request->get("no_rek")[$key];
            $data->banyak_buku = $request->get("banyak_buku")[$key];
            $data->sisa_banyak_buku = $request->get("banyak_buku")[$key];
            $data->jml_lembar = $request->get("banyak_buku")[$key] * 25;
            $data->sisa_jml_lembar = $request->get("banyak_buku")[$key] * 25;
            $data->jenis_buku = $request->get("jenis_buku")[$key];
            $data->status = 0;
            $data->save();
        }

        alert()->success('Success.', 'Permintaan Cek/Giro Berhasil disimpan');
        return redirect()->route('pengajuan_cek_giro.index');
    }

    public function view($kode)
    {
        $header = DB::table('izin_pengajuan_cek_giro_h')
            ->where('izin_pengajuan_cek_giro_h.kode_pengajuan_cek', $kode)->first();

        $details = DB::table('izin_pengajuan_cek_giro_d')
            ->join('perusahaans', 'izin_pengajuan_cek_giro_d.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('banks', 'izin_pengajuan_cek_giro_d.kode_bank', '=', 'banks.kode_bank')
            ->where('izin_pengajuan_cek_giro_d.kode_pengajuan_cek', $kode)->get();

        return view('finance.pengajuan_cek_giro.view', compact('header', 'details'));
    }

    public function store_terima(Request $request)
    {
		set_time_limit(300);
		
        $currentYear = now()->year;
        $lastNoIzin = DB::table('izin_h')
            ->select(DB::raw('CAST(SUBSTRING(no_izin, 3) AS UNSIGNED) as nomor'))
            ->orderBy('nomor', 'desc')
            ->first();

        if ($lastNoIzin) {
            $nextNumber = $lastNoIzin->nomor + 1;
        } else {
            // Jika belum ada nomor, mulai dari 1
            $nextNumber = 1;
        }

        // Tambahkan "H" di depan
        $newNoIzin = 'H-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);


        $getRow = DB::table('izin_h')
            ->select(DB::raw('SUBSTRING(kode_terima_cek, -3) AS NoUrut'))
            ->whereYear('tgl_izin', $currentYear)
            ->orderBy('NoUrut', 'desc')
            ->first();

        $currentDate = date('dmy'); // Menghasilkan tanggal dalam format 'ddmmy'

        if ($getRow) {
            $lastNoUrut = intval($getRow->NoUrut);
            $nextNoUrut = $lastNoUrut + 1;
        } else {
            // Jika belum ada data untuk tahun ini, mulai dari 1
            $nextNoUrut = 1;
        }

        $kode_terima = 'ACC' . $currentDate . str_pad($nextNoUrut, 3, '0', STR_PAD_LEFT);

        if ($request->has('chk')) {
            foreach ($request->input('chk') as $checkedIndex) {
                // Dapatkan data berdasarkan indeks checkbox yang dicentang
                $seriAwal = $request->get("seri_awal")[$checkedIndex - 1]; // Mengurangi 1 karena array dimulai dari 0
                $seriAkhir = $request->get("seri_akhir")[$checkedIndex - 1]; // Mengurangi 1 karena array dimulai dari 0
                $kodeSeriWarkat = $request->get("kode_warkat")[$checkedIndex - 1];
                $jenisBuku = $request->get("jenis_buku")[$checkedIndex - 1];
                $hurufPertamaJenisBuku = substr($jenisBuku, 0, 1);
                $kodeIzin = $hurufPertamaJenisBuku . '-' . $kodeSeriWarkat . $seriAwal;

                // // Cek apakah sudah
                // $exists = DB::table('izin_h')
                //     ->where('kode_buku', $kodeIzin)
                //     ->exists();

                // if ($exists) {
                //     alert()->error('Info.', 'Kode Seri Warkat: ' . $kodeSeriWarkat . ' dengan Seri Awal: ' . $seriAwal . ' dan Seri Akhir: ' . $seriAkhir . ' sudah ada.');
                //     return redirect()->route('pengajuan_cek_giro.view', ['kode_pengajuan' => $request->get('kode_permintaan')]);
                // } else {

                // Simpan ke database
                DB::table('izin_h')->insert([
                    'kode_buku' => $kodeIzin,
                    'tgl_izin' => $request->get('tgl'), //Carbon::now()->format('Y-m-d'),
                    // 'no_izin' => $newNoIzin,
                    'no_izin' => $request->get('no_izin'),
                    'judul_izin' => $request->get('judul_izin'),
                    'catatan' => $request->get('catatan'),
                    'kode_pengajuan_cek' => $request->get('kode_permintaan'),
                    'kode_terima_cek' => $kode_terima,
                    'id_penerima' => $request->get('kode_penerima_resi'),
                    'id_user_input' => Auth::user()->id
                ]);
            }

            //detail
            $datas = [];
            foreach ($request->input('seri_awal') as $key => $value) {
            }

            $validator = Validator::make($request->all(), $datas);

            foreach ($request->input("seri_awal") as $key => $value) {
                //  $jmlLembar = $request->get("jml_lembar")[$key];

                $seriAwal = $request->get("seri_awal")[$key]; // Mengurangi 1 karena array dimulai dari 0
                $seriAkhir = $request->get("seri_akhir")[$key]; // Mengurangi 1 karena array dimulai dari 0
                $kodeSeriWarkat = $request->get("kode_warkat")[$key];
                $jenisBuku = $request->get("jenis_buku")[$key];
                $hurufPertamaJenisBuku = substr($jenisBuku, 0, 1);
                $kodeIzin_d = $hurufPertamaJenisBuku . '-' . $kodeSeriWarkat . $seriAwal;

                $hiddenJmlLembar = $request->input("hidden_jml_lembar")[$key];

                // detail
                for ($i = 0; $i < $hiddenJmlLembar; $i++) {
                    $data = new Izin_H_Detail();
                    $data->kode_buku = $kodeIzin_d;
                    $data->kode_perusahaan = $request->get("kode_perusahaan")[$key];
                    $data->kode_bank = $request->get("kode_bank")[$key];
                    $data->no_rekening = $request->get("no_rekening")[$key];
                    $seri_awal = $request->get("seri_awal")[$key];
                    $hasil_jumlah = intval($seri_awal) + $i;
                    $data->id_cek = $request->get("kode_warkat")[$key] . ' ' . sprintf('%0' . strlen($seri_awal) . 'd', $hasil_jumlah);
                    $data->no_cek = sprintf('%0' . strlen($seri_awal) . 'd', $hasil_jumlah);
                    $data->kode_seri_warkat = $request->get("kode_warkat")[$key];
                    $data->seri_awal = $request->get("seri_awal")[$key];
                    $data->seri_akhir = $request->get("seri_akhir")[$key];
                    $data->jenis_warkat = $request->get("jenis_buku")[$key];
                    $data->jml_lembar = $hiddenJmlLembar;
                    //$data->no_urut = $no_urut;
                    $data->status = 1;
                    $data->save();
                }

                $sisa_jml_buku = DB::table('izin_pengajuan_cek_giro_d')
                    ->select('izin_pengajuan_cek_giro_d.sisa_banyak_buku')
                    ->where('izin_pengajuan_cek_giro_d.kode_pengajuan_cek', $request->get('kode_permintaan'))
                    ->where('izin_pengajuan_cek_giro_d.kode_perusahaan', $request->get("kode_perusahaan")[$key])
                    ->where('izin_pengajuan_cek_giro_d.no_rekening', $request->get("no_rekening")[$key])
                    ->first();
                //update
                $data_update = DB::table('izin_pengajuan_cek_giro_d')
                    ->select('izin_pengajuan_cek_giro_d.sisa_banyak_buku')
                    ->where('izin_pengajuan_cek_giro_d.kode_pengajuan_cek', $request->get('kode_permintaan'))
                    ->where('izin_pengajuan_cek_giro_d.kode_perusahaan', $request->get("kode_perusahaan")[$key])
                    ->where('izin_pengajuan_cek_giro_d.no_rekening', $request->get("no_rekening")[$key])
                    ->update([
                        'izin_pengajuan_cek_giro_d.sisa_banyak_buku' => $sisa_jml_buku->sisa_banyak_buku - 1
                    ]);

                alert()->success('Success.', 'Permintaan Cek/Giro Berhasil disimpan');
            }
            
            return redirect()->route('pengajuan_cek_giro.index');
            // }
        }
    }

    public function cekIzin(Request $request)
    {
        // Ambil input dari AJAX
        $jenisBuku = $request->input('jenis_buku');
        $kodePerusahaan = $request->get('kode_perusahaan');
        $kodeWarkat = $request->input('kode_warkat');
        $seriAwal = $request->input('seri_awal');

        $hurufPertamaJenisBuku = substr($jenisBuku, 0, 1);
        $kodeBuku = $hurufPertamaJenisBuku . '-' . $kodeWarkat . $seriAwal;
        // dd($kodeBuku, $perusahaan);

        // Cek apakah data sudah ada di database
        $exists = DB::table('izin_h_detail')
            ->where('kode_perusahaan', $kodePerusahaan)
            ->where('kode_buku', $kodeBuku)
            ->where('kode_seri_warkat', $kodeWarkat)
            ->where('seri_awal', $seriAwal)
            ->exists();

        // Kembalikan hasil pengecekan ke AJAX
        return response()->json(['exists' => $exists]);
    }

    public function pdf($kode)
    {
        $header = DB::table('izin_pengajuan_cek_giro_h')
            ->join('izin_h', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_h.kode_pengajuan_cek')
            ->join('users', 'izin_h.id_user_input', '=', 'users.id')
            ->leftJoin('users as user_approval', 'izin_h.id_user_approval', '=', 'user_approval.id')
            ->leftJoin('users as user_approval_bod', 'izin_h.id_user_approval_bod', '=', 'user_approval_bod.id')
            ->leftJoin('ms_pembawa_resi', 'izin_h.id_penerima', '=', 'ms_pembawa_resi.id')
            ->select(
                'izin_h.judul_izin',
                'izin_h.no_izin',
                'izin_h.tgl_izin',
                'izin_h.no_urut',
                'izin_h.id_user_input',
                'users.name',
                'ms_pembawa_resi.pembawa_resi',
                'izin_h.status_approval',
                'izin_h.id_user_approval',
                'user_approval.name as name_approval',
                'izin_h.tgl_approval',
                'izin_h.keterangan_approval',
                'izin_h.kode_approval',
                'izin_h.status_approval_bod',
                'izin_h.id_user_approval_bod',
                'user_approval_bod.name as name_approval_bod',
                'izin_h.tgl_approval_bod',
                'izin_h.keterangan_approval_bod',
                'izin_h.kode_approval_bod'
            )
            ->where('izin_h.kode_terima_cek', $kode)
            ->first();

        $detail = DB::table('izin_pengajuan_cek_giro_h')
            ->join('izin_h', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_h.kode_pengajuan_cek')
            ->join('izin_h_detail', 'izin_h.kode_buku', '=', 'izin_h_detail.kode_buku')
            ->join('perusahaans', 'izin_h_detail.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('banks', 'izin_h_detail.kode_bank', '=', 'banks.kode_bank')
            ->join('users', 'izin_h.id_user_input', '=', 'users.id')
            ->select(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_h.no_izin',
                'izin_h.tgl_izin',
                'izin_h_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_h_detail.kode_seri_warkat',
                'izin_h_detail.seri_awal',
                'izin_h_detail.seri_akhir',
                'izin_h_detail.kode_bank',
                'banks.nama_bank',
                'izin_h_detail.no_rekening',
                'izin_h_detail.jml_lembar',
                'izin_h_detail.jenis_warkat',
                'izin_h.id_user_input',
                'users.name',
                'izin_h.no_urut',
                'izin_h.kode_terima_cek'
            )
            ->groupBy(
                'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                'izin_h.no_izin',
                'izin_h.tgl_izin',
                'izin_h_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_h_detail.kode_seri_warkat',
                'izin_h_detail.seri_awal',
                'izin_h_detail.seri_akhir',
                'izin_h_detail.kode_bank',
                'banks.nama_bank',
                'izin_h_detail.no_rekening',
                'izin_h_detail.jml_lembar',
                'izin_h_detail.jenis_warkat',
                'izin_h.id_user_input',
                'users.name',
                'izin_h.no_urut',
                'izin_h.kode_terima_cek'
            )
            ->where('izin_h.kode_terima_cek', $kode)
            ->get();

        $total_jml = DB::table('izin_pengajuan_cek_giro_h')
            ->join('izin_h', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_h.kode_pengajuan_cek')
            ->join('izin_h_detail', 'izin_h.kode_buku', '=', 'izin_h_detail.kode_buku')
            ->select(DB::raw('count(izin_h_detail.jml_lembar) as total'))
            ->where('izin_h.kode_terima_cek', $kode)
            ->first();

        $pdf = PDF::loadview('finance.pengajuan_cek_giro.pdf', compact('header', 'detail', 'total_jml'))->setPaper('a4', 'portrait'); //landscape,portrait
        return $pdf->stream();
    }

    public function excel($kode)
    {
        // $header = DB::table('izin_h')
        //             ->join('users','izin_h.id_user_input','=','users.id')
        //             ->leftJoin('users as user_approval','izin_h.id_user_approval','=','user_approval.id')
        //             ->leftJoin('users as user_approval_bod','izin_h.id_user_approval_bod','=','user_approval_bod.id')
        //             ->select('izin_h.judul_izin','izin_h.no_izin','izin_h.tgl_izin','izin_h.no_urut','izin_h.id_user_input','users.name',
        //                     'izin_h.status_approval','izin_h.id_user_approval','user_approval.name as name_approval','izin_h.tgl_approval','izin_h.keterangan_approval','izin_h.kode_approval',
        //                     'izin_h.status_approval_bod','izin_h.id_user_approval_bod','user_approval_bod.name as name_approval_bod','izin_h.tgl_approval_bod','izin_h.keterangan_approval_bod','izin_h.kode_approval_bod')
        //             ->where('izin_h.kode_buku', $request->no_izin)
        //             ->first();

        $detail = DB::table('izin_h')
            ->join('izin_h_detail', 'izin_h.kode_buku', '=', 'izin_h_detail.kode_buku')
            ->join('perusahaans', 'izin_h_detail.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('banks', 'izin_h_detail.kode_bank', '=', 'banks.kode_bank')
            ->join('users', 'izin_h.id_user_input', '=', 'users.id')
            ->join('izin_pengajuan_cek_giro_h', 'izin_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek')
            ->join('ms_pembawa_resi', 'izin_h.id_penerima', '=', 'ms_pembawa_resi.id')
            ->select(
                'izin_h.kode_buku',
                'izin_h_detail.id_cek',
                'izin_h.tgl_izin',
                'izin_h.no_izin',
                'izin_h_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_h_detail.kode_bank',
                'banks.nama_bank',
                'izin_h_detail.no_rekening',
                'izin_h.id_user_input',
                'users.name',
                'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                'izin_h.id_penerima',
                'ms_pembawa_resi.pembawa_resi'
            )
            ->where('izin_h.kode_terima_cek', $kode)
            ->get();

        // $total_jml = DB::table('izin_h_detail')
        //                 ->select(DB::raw('count(izin_h_detail.jml_lembar) as total'))
        //                 ->where('izin_h_detail.kode_buku', $request->no_izin) 
        //                 ->first();           

        return view('finance.pengajuan_cek_giro.excel', compact('detail'));
    }
}
