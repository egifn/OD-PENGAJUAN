
@extends('layouts.admin')

@section('title')
    <title>Tagihan</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Tagihan Pembelian</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Tagihan Pembelian
                                <a href="#" class="btn btn-primary btn-sm float-right" hidden>List CO</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('tagihan_aqua_vit/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right"> 
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>  
                                <br>
                                <div class="card-body">
                                    <hr>
                                    <!-- <div class="row">
                                        <div class="col-md-3 mb-2">
                                            Total Saldo
                                            <input type="text" name="saldo" id="saldo" class="form-control" style="text-align: right; font-weight: bold;"  value="{{ number_format($total_aqua->total + $total_vit->total  ?? 0) }}" required readonly>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Total Tagihan
                                            <input type="text" name="tagihan" id="tagihan" class="form-control" style="text-align: right; font-weight: bold;"  value="{{ number_format($total_aqua->total + $total_vit->total  ?? 0) }}" required readonly>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Total Bayar
                                            <input type="text" name="total_bayar" id="total_bayar" class="form-control" style="text-align: right; font-weight: bold;" 
                                                value="0" required readonly>
                                        </div>
                                    </div> -->

                                    <div class="card-body">
                                        <div class="row">
                                        <div class="col-sm-2 col-lg-2">
                                                <div class="card text-white bg-secondary">
                                                    <div class="card-body pb-0">
                                                        <div style="font-weight: bold; color: black;">Total Aqua:</div>
                                                        <div class="text-value-lg" align="center" style="font-weight: bold; color: black; font-size:13px;">{{ number_format($qty_aqua->qty_aqua ?? 0) }}</div>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-lg-2">
                                                <div class="card text-white bg-secondary">
                                                    <div class="card-body pb-0">
                                                        <div style="font-weight: bold; color: black;">Total Vit:</div>
                                                        <div class="text-value-lg" align="center" style="font-weight: bold; color: black; font-size:13px;">{{ number_format($qty_vit->qty_vit ?? 0) }}</div>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-lg-2">
                                                <div class="card text-white bg-secondary">
                                                    <div class="card-body pb-0">
                                                        <div style="font-weight: bold; color: black;">Total Qty:</div>
                                                        <div class="text-value-lg" align="center" style="font-weight: bold; color: black; font-size:13px;">{{ number_format($qty_aqua->qty_aqua + $qty_vit->qty_vit ?? 0) }}</div>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-2 col-lg-2">
                                                <div class="card text-white bg-secondary">
                                                    <div class="card-body pb-0">
                                                        <div style="font-weight: bold; color: black;">Total Saldo:</div>
                                                        <div class="text-value-lg" align="center" style="font-weight: bold; color: black; font-size:13px;">{{ number_format($total_aqua->total + $total_vit->total  ?? 0) }}</div>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-2 col-lg-2">
                                                <div class="card text-white bg-secondary">
                                                    <div class="card-body pb-0">
                                                        <div style="font-weight: bold; color: black;">Total Tagihan:</div>
                                                        <div class="text-value-lg" align="center" style="font-weight: bold; color: black; font-size:13px;">{{ number_format($total_aqua->total + $total_vit->total  ?? 0) }}</div>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-2 col-lg-2">
                                                <div class="card text-white bg-secondary">
                                                    <div class="card-body pb-0">
                                                        <div style="font-weight: bold; color: black;">Total Bayar:</div>
                                                        <div class="text-value-lg" align="center" style="font-weight: bold; color: black; font-size:13px;">0</div>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                <th hidden>Invoice date</th>
                                                <th hidden>Actual Goods Issue Date</th>
                                                <th hidden> Sales Document Type</th>
                                                <th>Ship to</th>
                                                <th>Sold-To Party</th>
                                                <th>Plant</th>
                                                <th>Plant Description</th>
                                                <th>Delivery Number</th>
                                                <th>Material</th>
                                                <th hidden>External Delivery ID</th>
                                                <th hidden>Means of Trans. ID</th>
                                                <th>Ship To Name</th>
                                                <th>Sold to name</th>
                                                <th>Material Description</th>
                                                <th hidden>Billing Document</th>
                                                <th>Delivery SuM</th>
                                                <th hidden>Harga</th>
                                                <th hidden>Total Harga</th>
                                                <th>Invoice CAB</th>
                                                <th hidden>Invoice CAF</th>
                                                <th hidden>Invoice VAT Amount</th>
                                                <th hidden>Subsidi</th>
                                                <th hidden>Original Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($list_tagihan as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $val->po_number }}</td>
                                                <td>{{ $val->order_number }}</td>   
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td>{{ $val->sap_delivery_code }}</td>
                                                <td>{{ $val->sap_delivery_code }}</td>
                                                <td>{{ $val->source_id }}</td>
                                                <td>{{ $val->source_name }}</td>
                                                <td>{{ $val->dn_number }}</td>
                                                <td>{{ $val->material_id }}</td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td>{{ $val->ship_to_name }}</td>
                                                <td>{{ $val->sold_to_name }}</td>
                                                <td>{{ $val->sku }}</td>
                                                <td hidden></td>
                                                <td>{{ $val->delivery_sum }}</td>
                                                <td hidden>{{ $val->harga }}</td>
                                                <td hidden>{{ $val->delivery_sum * $val->harga  }}</td>
                                                <td>{{ number_format($val->delivery_sum * $val->harga)  }}</td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="24" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
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