@extends('layouts.admin')

@section('title')
    <!-- <title>Import Data DMS</title> -->
    <title>Upload File</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <!--<li class="breadcrumb-item active">Import Data DMS</li> -->
        <li class="breadcrumb-item active">Upload File</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                <!-- Import Data DMS
                                <a href="#" class="btn btn-warning btn-sm float-right">Import Data</a> -->
                                Upload File
                                <a href="{{ route('data_center_dms.create') }}" class="btn btn-warning btn-sm float-right">Upload File</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('data_center_dms/cari.cari') }}" method="get">
                                {{-- <div class="input-group mb-2 col-md-6 float-right">
                                    <input type="text" name="q" class="form-control" placeholder="Cari Data..." value="{{ request()->q }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Cari</button>
                                    </div>
                                </div> --}}

                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-hover table-striped table-sm">
                                        <thead>
                                       <!-- <tr>
                                                <th>No</th>
                                                <th hidden>Id</th>
                                                <th>Area</th>
                                                <th>Kode Depo</th>
                                                <th>Nama Depo</th>
                                                <th>Kode Customer 1</th>
                                                <th>kode Customer 2</th>
                                                <th>Tanggal DO</th>
                                                <th>Minggu</th>
                                                <th>Hari</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Bulan</th>
                                                <th>Kode Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Produk</th>
                                                <th>Convert Prodak</th>
                                                <th>Merk Produk</th>
                                                <th>Tanggal Join</th>
                                                <th>Promo</th>
                                                <th>Kode DO</th>
                                                <th>Qty</th>
                                                <th>C_Qty</th>
                                                <th>Qty 2</th>
                                                <th>Diskon Distributor</th>
                                                <th>Jumlah</th>
                                                <th>Nama Customer</th>
                                                <th>Alamat</th>
                                                <th>Segmen</th>
                                                <th>Sub Segmen</th>
                                                <th>Con Segmen</th>
                                                <th>Convert Segmen</th>
                                                <th>Kode Driver</th>
                                                <th>Nama Driver</th>
                                                <th>Kode Helper 1</th>
                                                <th>Nama Helper 1</th>
                                                <th>Kode Helper 2</th>
                                                <th>Nama Helper 2</th>
                                                <th>Kode Sales</th>
                                                <th>Nama Sales</th>
                                                <th>No Kemdaraan</th>
                                                <th>Kota</th>
                                                <th>Tipe Penjualan</th>
                                                <th>Status Dok</th>
                                                <th>Satuan</th>
                                                <th>Kecamatan</th>
                                                <th hidden>User Input</th>
                                                <th>Aksi</th>
                                            </tr> -->
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Id</th>
                                                <th>Tgl Upload</th>
                                                <th>Nama File</th>
                                                <th>Keterangan</th>
                                                <th hidden>Id User Input</th>
                                                <th hidden>Nama User Input</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse ($data as $val)
                                            <tr>
                                                {{-- <td>{{ $no }}</td>
                                                <td hidden>{{ $val->id }}</td>
                                                <td>{{ $val->area }}</td>
                                                <td>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->kode_customer }}</td>
                                                <td>{{ $val->kode_customer_2 }}</td>
                                                <td>{{ $val->do_date }}</td>
                                                <td>{{ $val->week }}</td>
                                                <td>{{ $val->day }}</td>
                                                <td>{{ $val->month }}</td>
                                                <td>{{ $val->year }}</td>
                                                <td>{{ $val->kode_produk }}</td>
                                                <td>{{ $val->nama_produk }}</td>
                                                <td>{{ $val->produk }}</td>
                                                <td>{{ $val->convert_nama_produk }}</td>
                                                <td>{{ $val->merk_produk }}</td>
                                                <td>{{ $val->tgl_join }}</td>
                                                <td>{{ $val->id_promo }}</td>
                                                <td>{{ $val->do_id }}</td>
                                                <td>{{ $val->qty }}</td>
                                                <td>{{ $val->c_qty }}</td>
                                                <td>{{ $val->qty_2 }}</td>
                                                <td>{{ $val->dikon_distributor }}</td>
                                                <td>{{ $val->jumlah }}</td>
                                                <td>{{ $val->nama_customer }}</td>
                                                <td>{{ $val->alamat }}</td>
                                                <td>{{ $val->segmen }}</td>
                                                <td>{{ $val->sub_segmen }}</td>
                                                <td>{{ $val->con_segmen }}</td>
                                                <td>{{ $val->convert_segmen }}</td>
                                                <td>{{ $val->c_seg }}</td>
                                                <td>{{ $val->kode_driver }}</td>
                                                <td>{{ $val->nama_driver }}</td>
                                                <td>{{ $val->kode_helper_1 }}</td>
                                                <td>{{ $val->nama_helper_1 }}</td>
                                                <td>{{ $val->kode_helper_2 }}</td>
                                                <td>{{ $val->nama_helper_2 }}</td>
                                                <td>{{ $val->kode_sales }}</td>
                                                <td>{{ $val->nama_sales }}</td>
                                                <td>{{ $val->no_kendaraan }}</td>
                                                <td>{{ $val->kota }}</td>
                                                <td>{{ $val->tipe_penjualan }}</td>
                                                <td>{{ $val->status_dok }}</td>
                                                <td>{{ $val->satuan }}</td>
                                                <td>{{ $val->kecamatan }}</td>
                                                <td hidden>{{ $val->id_user_import }}</td>
                                                <td>Aksi</td> --}}

                                                <td>{{ $no }}</td>
                                                <td hidden>{{ $val->id }}</td>
                                                <td>{{ $val->tgl_upload }}</td>
                                                <td>{{ $val->filename_upload }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td hidden>{{ $val->id_user_input }}</td>
                                                <td hidden></td>
                                            </tr>
                                            <?php $no++ ?>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            {{-- {!! $data->links() !!} --}}
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(document).ready(function() {
            //INISIASI DATERANGEPICKER
            $('#tanggal').daterangepicker({
            
            })
        })
    </script>
@endsection

