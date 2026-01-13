@extends('layouts.admin')

@section('title')
    <title>Segmen IOD</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Monitoring Saldo</li>
        <li class="breadcrumb-item active">Segmen IOD</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="get">
                                 
                            </form>
                            <h4 class="card-title">SEGMEN IOD</h4>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                    <table id="datatabel" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>No</th>
                                                <th>ID DEPO</th>
                                                <th>NAMA DEPO</th>
												<th>ENTITAS</th>
                                                <th>TANGGAL</th>
                                                <th>ID PELANGGAN</th>
                                                <th>NAMA PELANGGAN</th>
                                                <th>SEGMEN</th>
                                                <th>NO DO</th>
                                                <th>ID SALESMAN</th>
                                                <th>SALESMAN</th>
                                                <th>KENDARAAN</th>
                                                <th>TIPE SALES</th>
                                                <th>ID PRODUK</th>
                                                <th>NAMA PRODUK</th>
                                                <th>TIPE PENJUALAN</th>
                                                <th>SATUAN</th>
                                                <th>PRINCIPAL</th>
                                                <th>BRAND</th>
                                                <th>SKU</th>
                                                <th>QTY</th>
                                                <th>AFTER PROMO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data_iod as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->ID_DEPO }}</td>
                                                <td>{{ $val->NAMA_DEPO }}</td>
                                                <td>{{ $val->ENTITAS }}</td>
                                                <td>{{ $val->TANGGAL }}</td>
                                                <td>{{ $val->ID_PELANGGAN }}</td>
                                                <td>{{ $val->NAMA_PELANGGAN }}</td>
                                                <td>{{ $val->SEGMEN }}</td>
                                                <td>{{ $val->NO_DO }}</td>
                                                <td>{{ $val->ID_SALESMAN }}</td>
                                                <td>{{ $val->SALESMAN }}</td>
                                                <td>{{ $val->KENDARAAN }}</td>
                                                <td>{{ $val->TIPE_SALES }}</td>
                                                <td>{{ $val->ID_PRODUK }}</td>
                                                <td>{{ $val->NAMA_PRODUK }}</td>
                                                <td>{{ $val->TIPE_PENJUALAN }}</td>
                                                <td>{{ $val->SATUAN }}</td>
                                                <td>{{ $val->PRINCIPAL }}</td>
                                                <td>{{ $val->BRAND }}</td>
                                                <td>{{ $val->SKU }}</td>
                                                <td>{{ $val->QTY }}</td>
                                                <td>{{ number_format($val->AFTER_PROMO) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                               
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                
                            </div>
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
    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: false,
                bFilter: false,
                lengthChange: false,
                scrollY: "355px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

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