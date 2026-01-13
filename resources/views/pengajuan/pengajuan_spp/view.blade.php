@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Detail Pengajuan SPP</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item active">Detail Pengajuan SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Pengajuan SPP - {{ $pengajuan_biaya_head->kode_pengajuan_b }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_biaya_head->tgl_pengajuan_b }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama_pemohon" class="form-control" value="{{ $pengajuan_biaya_head->name }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Company Name
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $pengajuan_biaya_head->nama_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="nama_depo" class="form-control" value="{{ $pengajuan_biaya_head->nama_depo }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Keterangan
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_biaya_head->keterangan }}" readonly>
                                        
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        <label for="jenis">Division</label>
                                        <input type="text" name="divisi" class="form-control" value="{{ $pengajuan_biaya_head->nama_divisi }}" readonly>
                                    </div>
                                    
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Kategori Pengeluaran
                                        <input type="text" name="nama" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Sifat Pengeluaran
                                        <input type="text" name="sifat_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->sifat }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jenis Pengeluaran
                                        <input type="text" name="jenis_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->jenis }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Sistem Pembayaran
                                        <input type="text" name="sistem_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->pembayaran }}" readonly>
                                    </div>
                                    
                                    
                                </div>
                                
                               
                            </div>
                        </div>
                    </div>

                    
                
                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:150px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Kode</th>
                                                    <th>Uraian</th>
                                                    <th>Spesifikasi</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga</th>
                                                    <th>Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($pengajuan_biaya_detail as $row)
                                                <tr>
                                                    <td hidden>#</td>
                                                    <td>{{ $row->kode_pengajuan_b}}</td>
                                                    <td>{{ $row->description}}</td>
                                                    <td>{{ $row->spesifikasi}}</td>
                                                    <td align="right">{{ $row->qty }}</td>
                                                    <td align="right">{{ number_format($row->harga)}}</td>
                                                    <td align="right">{{ number_format($row->tharga)}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <td colspan="5" style="text-align: center; font-size: 15;"><b>T o t a l : </b></td>
                                                <td align="right">
                                                    <input type="text" class="form-control" name="total_biaya" id="total_biaya" style="text-align: right; width: 120px;" value="{{ number_format($pengajuan_biaya_detail_total) }}" readonly>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
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


