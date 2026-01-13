<?php

namespace App\Http\Controllers\Claim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Auth;
use App\MasterSuratTemplate;

class SuratFormatController extends Controller
{
    public function index()
    {
    	$format_surat = DB::table('ms_surat_template')
    					->join('perusahaans','ms_surat_template.kode_perusahaan','=','perusahaans.kode_perusahaan')
    					->get();

    	return view ('claim.surat_template.index', compact('format_surat'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            
        ]);

        MasterSuratTemplate::create([
        	'kode_perusahaan' => $request->get('kode_perusahaan'),
        	'header_judul' => $request->get('judul'),
        	'header_alamat' => $request->get('h_alamat'),
        	'kepada' => $request->get('kepada'),
        	'alamat_tujuan_1' => $request->get('alamat_1'),
        	'alamat_tujuan_2' => $request->get('alamat_2'),
        	'alamat_tujuan_3' => $request->get('alamat_3'),
        	'prihal' => $request->get('prihal'),
        	'up' => $request->get('up'),
        	'isi_1' => $request->get('isi'),
        	'isi_2' => $request->get('isi_2'),
        	'penutup' => $request->get('penutup')
        ]);

        Alert()->success('Success.','Data Berhasil ditambahkan');
        return redirect()->route('format_surat.index');
    }
}
