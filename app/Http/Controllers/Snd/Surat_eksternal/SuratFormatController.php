<?php

namespace App\Http\Controllers\Snd\Surat_eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratFormatController extends Controller
{
    public function index()
    {
    	$format_surat = DB::table('ms_surat_template_program_eks')
    					->join('perusahaans','ms_surat_template_program_eks.kode_perusahaan','=','perusahaans.kode_perusahaan')
    					->get();

        return view ('snd.surat_eksternal.format.index', compact('format_surat'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            
        ]);

        DB::table('ms_surat_template_program_eks')->insert([
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
        return redirect()->route('format_surat_program_eks.index');
    }
}
