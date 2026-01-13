<?php

namespace App\Http\Controllers\Piutang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Data_Pelunasan;
use App\CatatanSaldo;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelunasanController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_divisi == '24') { //-- Jika Piutang --
            $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->get();

            $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->first();
        } elseif (Auth::user()->kode_divisi == '25') { //-- Kasir --
            $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 0)
                ->get();

            $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 0)
                ->first();
        } elseif (Auth::user()->kode_divisi == '8') { //--jika Rekonsiliasi--
            $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->get();

            $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->first();
        }

        return view('piutang.pelunasan.index', compact('pelunasan', 'total'));
    }
	
	#untuk menampilkan yang sudah dikirim dari kasir
    public function view()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->get();

        $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->first();

        return view('piutang.pelunasan.payment', compact('pelunasan', 'total'));
    }

    public function cari_view(Request $request)
    {
        if (request()->tanggal != '') {
            $date = explode(' - ', request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->get();

        $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->first();

        return view('piutang.pelunasan.payment', compact('pelunasan', 'total'));
    }

    public function actionRekening(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('catatan_saldo')
                    ->Where('status', 0)
                    ->Where('account_no', 'like', '%' . $query . '%')
                    //->Where('description', 'like', '%' . $query . '%')
                    ->get();
            } else {
                $data = DB::table('catatan_saldo')
                    ->Where('status', 0)
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_rek" data-id="' . $row->id . '" data-account="' . $row->account_no . '" data-tanggal="' . $row->transaction_date . '" data-keterangan="' . $row->description . '" data-kredit="' . $row->kredit . '" >
                            <td hidden>' . $row->id . '</td>
                            <td>' . $row->account_no . '</td>
                            <td>' . $row->transaction_date . '</td>
                            <td>' . $row->description . '</td>
                            <td align="right">' . number_format($row->kredit) . '</td>
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

    public function getDms(Request $request)
    {
        $nominal = $request->get('nominal');
        $date_jt = $request->get('date_jt');

        $query = DB::connection('mysql_tua')
            ->table('dms_cas_docbgreceipt')
            ->join('dms_cas_docbgreceiptitem', 'dms_cas_docbgreceipt.szdocid', '=', 'dms_cas_docbgreceiptitem.szDocId')
            ->join('dms_ar_customer', 'dms_cas_docbgreceiptitem.szCustomerId', '=', 'dms_ar_customer.szId')
            ->join('dms_cas_bank', 'dms_cas_docbgreceiptitem.szBankId', '=', 'dms_cas_bank.szId')
            ->select('dms_cas_docbgreceiptitem.decAmount', 'dms_cas_docbgreceiptitem.szCustomerId', 'dms_ar_customer.szName', 'dms_cas_bank.szName as nama_bank')
            ->where('dms_cas_docbgreceiptitem.decAmount', 'like', '%' . $nominal . '%')
            ->where('dms_cas_docbgreceiptitem.dtmDue', $date_jt);
        $data  = $query->first();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];
        return response()->json($output, 200);
    }

    public function getDmsInvoice(Request $request)
    {
        
    }

    public function cari(Request $request)
    {
        if (request()->tanggal != '') {
            $date = explode(' - ', request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_divisi == '24') { //-- Jika Piutang --
            $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->get();

            $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->first();
        } elseif (Auth::user()->kode_divisi == '25') { //-- Kasir --
            $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 0)
                ->get();

            $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 0)
                ->first();
        } elseif (Auth::user()->kode_divisi == '8') { //--jika Rekonsiliasi--
            $pelunasan = DB::table('data_pelunasan')
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->get();

            $total = DB::table('data_pelunasan')
                ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                ->WhereBetween('data_pelunasan.tanggal', [$date_start, $date_end])
                ->Where('data_pelunasan.status_ceklis', 1)
                ->first();
        }

        return view('piutang.pelunasan.index', compact('pelunasan', 'total'));
    }

    public function create(Request $request)
    {
        return view('piutang.pelunasan.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, []);

        Data_Pelunasan::create([
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'no_cek' => $request->get('no_cek'),
            'nominal' => str_replace(",", "", $request->get('nominal')),
            'jatuh_tempo' => $request->get('jt'),
            'id_pelanggan' => $request->get('id_pelanggan'),
            'nama_pelanggan' => $request->get('nama_pelanggan'),
            'bank' => $request->get('bank'),
            'id_user_input' => Auth::user()->id,
            'status_cek' => 'Deposit'
        ]);

        $catatansaldo_update = CatatanSaldo::find($request->get('id_saldo'));
        $catatansaldo_update->update([
            'status' => '1'
        ]);

        alert()->success('Success.', 'Data Pelunasan berhasil dibuat');
        return redirect()->route('pelunasan.create');
    }

    public function kirim(Request $request)
    {
        $datas = [];
        foreach ($request->input('no_cek') as $key => $value) {
        }

        $validator = Validator::make($request->all(), $datas);
        $no = 1;
        foreach ($request->input('no_cek') as $key => $value) {
            if ($request->get("chk" . $no) == 1) {
                $chkd = 1;
            } else {
                $chkd = 0;
            }
            $stock = DB::table('data_pelunasan')
                ->select('data_pelunasan.status_ceklis')
                ->Where('data_pelunasan.no_cek', $request->get("no_cek")[$key])
                ->update([
                    'status_ceklis' => $chkd
                ]);
            $no++;
        }
        alert()->success('Berhasil.', 'Pengiriman Data Pelunasan Berhasil...');
        return redirect()->route('pelunasan.index');
    }
    
    public function getDetailDataPayment(Request $request)
    {
        $data = DB::table('data_pelunasan')
                ->join('catatan_saldo','data_pelunasan.nominal','=','catatan_saldo.kredit')
                ->select('data_pelunasan.id','data_pelunasan.tanggal','data_pelunasan.no_cek','data_pelunasan.nominal','data_pelunasan.jatuh_tempo',
                'data_pelunasan.id_pelanggan','data_pelunasan.nama_pelanggan','data_pelunasan.bank','catatan_saldo.description')
                ->where('data_pelunasan.id', $request->id)
                ->first();

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function update(Request $request)
    {
        
    }
}
