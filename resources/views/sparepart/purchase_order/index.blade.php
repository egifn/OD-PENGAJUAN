@extends('layouts.admin')

@section('title')
    <title>Purchase Order</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Sparepart</li>
        <li class="breadcrumb-item active">Purchase Order</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Purchase Order
                            </h4>
                        </div>

                        

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('purchase_order/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <select name="perusahaan" class="form-control" hidden>
                                        <option value="">Company Name</option>
                                        
                                    </select>
                                    &nbsp
                                    <select name="depo" class="form-control" hidden>
                                        <option value="">Depo Name</option>
                                        
                                    </select>
                                    &nbsp
                                    <input type="text" id="date" name="date" class="form-control" value="{{ request()->date }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">Search</button>
                                </div>    
                            </form>
                            

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>PO Number</th>
                                                <th>Date</th>
                                                <th hidden>Code</th>
                                                <th hidden>kode vendor</th>
                                                <th>Vendor</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($po as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td><strong>{{ $val->part_purchase_order_h_code }}</strong></td>
                                                <td>{{ $val->part_purchase_order_date }}</td>
                                                <td hidden></td>
                                                <td hidden>{{ $val->part_purchase_order_supplier }}</td>
                                                <td>{{ $val->supp_desc }}</td>
                                                <td align="right">{{ number_format($val->total_price) }}</td>
                                                <td align="center">   
                                                    <a href="{{ route('purchase_order/view.view', $val->part_purchase_order_h_code) }}" class="btn btn-primary btn-sm">View</a> 
                                                    <a href="{{ route('purchase_order/pdf.pdf', $val->part_purchase_order_h_code) }}" target="_blank" class="btn btn-warning btn-sm">Print</a>   
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data available</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- PAGINATION  -->
                            
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
            let start_dms = moment().startOf('month')
            let end_dms = moment().endOf('month')

            //INISIASI DATERANGEPICKER
            $('#date').daterangepicker({
               
            })


            let start_bank = moment().startOf('month')
            let end_bank = moment().endOf('month')

            
        })
    </script>

@endsection


