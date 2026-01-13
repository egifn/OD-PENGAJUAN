@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Create SPPD</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item">SPPD</li>
        <li class="breadcrumb-item active">Detail SPPD</li>
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
                                        <input type="text" name="id" class="form-control" value="{{ $pengajuan_sppd_v->kode_pengajuan_sppd }}" required readonly hidden>
                                        <input type="text" name="pelaksana" class="form-control" value="{{ $pengajuan_sppd_v->pelaksana }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Divisi/Jabatan
                                        <input type="text" name="divisi" id="divisi" class="form-control" value="{{ $pengajuan_sppd_v->nama_divisi }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ $pengajuan_sppd_v->nama_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Depo
                                        <input type="text" name="depo" id="depo" class="form-control" value="{{ $pengajuan_sppd_v->nama_depo }}" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Kendaraan yg digunakan
                                        <input type="text" name="kendaraan" id="kendaraan" class="form-control" value="{{ $pengajuan_sppd_v->kendaraan }}" readonly required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        sebagai
                                        <input type="text" name="sebagai" id="sebagai" class="form-control" value="{{ $pengajuan_sppd_v->sebagai }}" readonly required>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $pengajuan_sppd_v->nama_pengeluaran }}" readonly required>
                                    </div>
                                    <div class="col-md-1 mb-2"></div>
                                </div>
                                <br>
                                  
                                    {{-- <div class="col-md-3 mb-2">
                                        Tujuan/Lokasi Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $pengajuan_sppd_v->tujuan_perusahaan_1 }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-">
                                        Tujuan/Lokasi Depo
                                        <input type="text" name="kode_depo_tujuan" id="kode_depo_tujuan" class="form-control" value="{{ $pengajuan_sppd_v->tujuan_depo_1 }}" required readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Keperluan Tugas
                                        <textarea name="keperluan" id="keperluan" rows="1" class="form-control" readonly>{{ $pengajuan_sppd_v->keperluan }}</textarea>
                                    </div> --}}

                                    <div class="table-responsive">
                                        <!-- <table class="table table-hover table-bordered"> -->
                                        
                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Pengajuan</th>
                                                        <th>Tujuan Perusahaan</th>
                                                        <th>Tujuan Depo</th>
                                                        <th>Dari Tgl</th>
                                                        <th>Sampai Tgl</th>
                                                        <th>Jml Hari</th>
                                                        <th>Keperluan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no=1; ?>
                                                    @forelse($detailSppd as $val)
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $val->kode_pengajuan_sppd }}</td>
                                                        <td>{{ $val->nama_perusahaan }}</td>
                                                        <td>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->tgl_mulai }}</td>
                                                        <td>{{ $val->tgl_akhir }}</td>
                                                        <td>{{ $val->jml_hari }}</td>
                                                        <td>{{ $val->keperluan }}</td>
                                                    </tr>
                                                    <?php $no++; ?>
                                                    @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                    
                                    </div>
                                
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

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_category" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Pengeluaran</th>
                                <th>Sifat</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')



@endsection




