
@extends('layouts.admin')

@section('title')
    <title>Data Import Tagihan TIV</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Aqua</li>
        <li class="breadcrumb-item active">Data Import Tagihan TIV</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Data Import Tagihan TIV
                                <a href="#" class="btn btn-primary btn-sm float-right" hidden>Data Import</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('list_pembelian_aqua/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right"> 
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Purchase Order Number</th>
                                                <th>Order number</th>
                                                <th>Invoice date</th>
                                                <th>Actual Goods Issue Date</th>   
                                                <th>Sales Document Type</th>
                                                <th>Ship to</th>
                                                <th>Sold-To Party</th>
                                                <th>Plant</th>
                                                <th>Plant Description</th>
                                                <th>Delivery number</th>
                                                <th>Material</th>
                                                <th>External Delivery ID</th>
                                                <th>Means of Trans. ID</th>
                                                <th>Ship to name</th>
                                                <th>Sold to name</th>
                                                <th>Material description</th>
                                                <th>Billing Document</th>
                                                <th>Delivery SuM</th>
                                                <th>Invoice CAB</th>
                                                <th>Invoice CAF</th>
                                                <th>Invoice VAT Amount</th>
                                                <th>Subsidi</th>
                                                <th>Original Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($list as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td hidden>{{ $val->kode_otm_h }}</td>
                                                <td hidden>{{ $val->tgl_otm_h }}</td>
                                                <td>{{ $val->order_id }}</td>
                                                <td>{{ $val->shipment_id }}</td>   
                                                <td>{{ $val->sap_order_no }}</td>
                                                <td>{{ $val->order_creation_date }}</td>
                                                <td>{{ $val->order_type }}</td>
                                                <td>{{ $val->material_id }}</td>
                                                <td>{{ $val->material_desc }}</td>
                                                <td>{{ $val->source_id }}</td>
                                                <td>{{ $val->source_name }}</td>
                                                <td>{{ $val->dest_id }}</td>
                                                <td>{{ $val->dest_name }}</td>
                                                <td>{{ $val->sap_delivery_code }}</td>
                                                <td>{{ $val->storage_loc }}</td>
                                                <td>{{ $val->planned_transporter_id }}</td>
                                                <td>{{ $val->planned_transporter_name }}</td>
                                                <td>{{ $val->actual_transporter_id }}</td>
                                                <td>{{ $val->actual_transporter_name }}</td>
                                                <td>{{ $val->planned_quantity }}</td>
                                                <td>{{ $val->actual_quantity }}</td>
                                                <td>{{ $val->planned_pickup_date }}</td>
                                                <td>{{ $val->actual_pickup_date }}</td>
                                                <td>{{ $val->dn_number }}</td>
                                                <td>{{ $val->sj_depo }}</td>
                                                <td hidden>{{ $val->qa }}</td>
                                                <td hidden>{{ $val->qb }}</td>
                                                <td hidden>{{ $val->blank }}</td>
                                                <td>{{ $val->truck_type }}</td>
                                                <td hidden>{{ $val->id_user_input }}</td>
                                                <td>{{ $val->name }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="19" class="text-center">Tidak ada data</td>
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

    <!-- UNTUK TABLE -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                scrollY: "270px",
                scrollX: "270px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 2,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script> -->

@endsection