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

<script type="text/javascript">
    

</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Pengajuan Biaya BBM Sales</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">Pengajuan Biaya BBM Sales</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Biaya BBM Sales
                                <a href="{{ route('pengajuan_b_bbm_sales_lnjtn.create') }}" class="btn btn-primary btn-sm float-right">Buat Pengajuan</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_b_bbm_sales_lnjtn/cari_index.cari_index') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">    
                                 <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th hidden>No Urut</th>
                                            <th>Kode Pengajuan</th>
                                            <th>Tgl Pengajuan</th>
                                            <th hidden>Kode Perusahaan</th>
                                            <th hidden>Kode Depo</th>
                                            <th>Perusahaan</th>
                                            <th>Depo</th>
                                            <th hidden>Kategori</th>
                                            <th>Permintaan Pengajuan</th>
                                            <th>Periode Pengisian</th>
                                            <th>Total</th>
                                            <th>Pengajuan Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
                                        @forelse($pengajuan_bbm as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                <td hidden>{{ $val->kode_perusahaan}}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kategori }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td>{{ $val->no_surat_program }}</td> <!-- isi ini adalah Periode Pengisian -->
                                                <td align="right">{{ number_format($val->tharga) }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    <a href="{{ route('pengajuan_b_bbm_sales_lnjtn/view.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                </td>
                                            </tr>

                                            @empty
                                            <tr>
                                                <td colspan="12" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse    
                                    </tbody>
                                    <tfoot id="table_footer">

                                    </tfoot>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection

