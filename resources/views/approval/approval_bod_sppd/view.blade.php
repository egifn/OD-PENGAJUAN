@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>View SPPD</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">SPPD</li>
        <li class="breadcrumb-item">Daftar Pengajuan</li>
        <li class="breadcrumb-item active">View Detail SPPD</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail SPPD</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Pelaksana Tugas
                                        <input type="text" name="kode_pengajuan_sppd" id="kode_pengajuan_sppd" class="form-control" value="{{ $view_approval_sppd->kode_pengajuan_sppd }}" required readonly hidden>
                                        <input type="text" name="pelaksana" class="form-control" value="{{ $view_approval_sppd->pelaksana }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Divisi
                                        <input type="text" name="divisi" id="divisi" class="form-control" value="{{ $view_approval_sppd->nama_divisi }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ $view_approval_sppd->nama_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Depo
                                        <input type="text" name="depo" id="depo" class="form-control" value="{{ $view_approval_sppd->nama_depo }}" required readonly>
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Tujuan/Lokasi Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $view_approval_sppd->tujuan_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-">
                                        Tujuan/Lokasi Depo
                                        <input type="text" name="kode_depo_tujuan" id="kode_depo_tujuan" class="form-control" value="{{ $view_approval_sppd->tujuan_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Keperluan Tugas
                                        <textarea name="keperluan" id="keperluan" rows="1" class="form-control" readonly>{{ $view_approval_sppd->keperluan }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Lama Tugas (dari)
                                        <input type="text" name="lama_tugas" id="lama_tugas" class="form-control" value="{{ date('d-M-Y', strtotime($view_approval_sppd->tgl_mulai)) }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        (sampai)
                                        <input type="text" name="sampai" id="sampai" class="form-control" value="{{ date('d-M-Y', strtotime($view_approval_sppd->tgl_akhir)) }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Kendaraan yg digunakan
                                        <input type="text" name="kendaraan" id="kendaraan" class="form-control" value="{{ $view_approval_sppd->kendaraan }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        sebagai
                                        <input type="text" name="sebagai" id="sebagai" class="form-control" value="{{ $view_approval_sppd->sebagai }}" readonly required>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_approval_sppd->nama_pengeluaran }}" readonly required>
                                    </div>
                                </div>

                                @if(Auth::user()->kode_divisi == '16') <!-- Jika Biaya-->
                                <hr>
                                <span><b>Rincian Biaya:</b></span>
                                {{-- <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Biaya SPPD
                                        @if($rowCount > 0)
                                            <input type="text" name="uang_sppd" id="uang_sppd" class="form-control" style="text-align: right;" value="{{ number_format($rincian_sppd->total_uang) }}" readonly>
                                        @else
                                            <input type="text" name="uang_sppd" id="uang_sppd" class="form-control" style="text-align: right;" value="0" onchange="jml_total_uang_sppd();" onkeyup="jml_total_uang_sppd();" required>
                                        @endif
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        x
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        Jumlah
                                        @if($rowCount > 0)
                                            <input type="text" name="jumlah_sppd" id="jumlah_sppd" class="form-control" style="text-align: right;" value="{{ $rincian_sppd->jml }}" readonly>
                                        @else
                                            <input type="text" name="jumlah_sppd" id="jumlah_sppd" class="form-control" style="text-align: right;" value="1" readonly required>
                                        @endif
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        =
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        total
                                        @if($rowCount > 0)
                                            <input type="text" name="total_sppd" id="total_sppd" class="form-control" style="text-align: right;" value="{{ number_format($rincian_sppd->subtotal) }}" readonly>
                                        @else
                                            <input type="text" name="total_sppd" id="total_sppd" class="form-control" style="text-align: right;" value="0" readonly required>
                                        @endif
                                        
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_masuk_sppd->nama_pengeluaran }}" readonly required>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Uang BBM
                                        <input type="text" name="uang_bbm" id="uang_bbm" class="form-control" style="text-align: right;" value="{{ number_format($data_bbm->uang) }}" readonly required>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        x
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jumlah
                                        <input type="text" name="jumlah" id="jumlah" class="form-control" style="text-align: right;" value="1" readonly required>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        =
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        total
                                        <input type="text" name="total" id="total" class="form-control" style="text-align: right;" value="{{ number_format($data_bbm->uang * 1) }}" readonly required>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="#" readonly required>
                                    </div>
                                </div>
                                @endif
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12 mb-2" align="right">
                                        <br>
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</main>


@endsection

@section('script')



@endsection




