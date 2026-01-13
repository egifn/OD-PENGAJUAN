@extends('layouts.admin')

@section('title')
    <title>Data Rekap Pengajuan ATK</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Data Rekap ATK</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Data Rekap Pengajuan ATK
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('rekap_data_atk/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>No Urut</th>
                                                <th>Kode</th>
                                                <th>Periode</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Pengajuan Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse($data_rekap as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td><strong>{{ $val->kode_rekap }}</strong></td>
                                                <td>{{ $val->periode }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_rekap)) }}</td>
                                                <td align="center">
                                                    @if($val->status == '0')
                                                        <label class="badge badge-primary">Baru</label> 
                                                    @elseif($val->status == '1')
                                                        <label class="badge badge-success">Approved</label>  
                                                    @elseif($val->status == '2')
                                                        <label class="badge badge-warning">Pending</label>  
                                                    @endif
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    @if($val->status == '2')
                                                        <a href="{{ route('rekap_data_atk_update.ubah', $val->no_urut) }}" class="btn btn-warning btn-sm">Update</a>  
                                                    @else
                                                        <a href="{{ route('rekap_data_atk_update.ubah', $val->no_urut) }}" class="btn btn-warning btn-sm" hidden>Update</a>  
                                                    @endif
                                                    <a href="{{ route('rekap_data_atk.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
													<a href="{{ route('rekap_data_atk/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- <form action="#" target="_blank" method="get" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm" name="btn_excel" id="btn_excel" value="excel">Excel</button>
                                    <button type="submit" class="btn btn-danger btn-sm" name="btn_pdf" id="btn_pdf" value="pdf">Pdf</button>
                                    <button class="btn btn-primary btn-sm" onclick="goBack()">Kembali</button>
                                    
                                </div>
                            </form> --}}
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            
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