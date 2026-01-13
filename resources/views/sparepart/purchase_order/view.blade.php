@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Purchase Order View</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Sparepart</li>
        <li class="breadcrumb-item">Purchase Order</li>
        <li class="breadcrumb-item active">Purchase Order View</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Purchase Order (View)
                                    
                                    <a href="{{ route('purchase_order/pdf.pdf', $po_head->part_purchase_order_h_code) }}" target="_blank" class="btn btn-warning btn-sm float-right""><b>P r i n t</b></a>   
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">Purchase Order : <b>{{ $po_head->part_purchase_order_h_code }}</b></label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">Purchase Request : <b>{{ $po_head->part_purchase_order_reqcode }}</b></label>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Supplier : <b>{{ $po_head->supp_desc }}</b></label>
                                    </div>

                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="supplier">Date : <b>{{ $po_head->part_purchase_order_date }}</b></label>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Manager : <b>{{ $po_head->mgr }}</b></label>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">Operator : <b>{{ $po_head->part_purchase_order_operator }}</b></label>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="nama">Approved : <b>{{ $po_head->Appoved }}</b></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="nama">Code : <b>{{ $group_vendor->kelompok }}-{{ $group_vendor->sub_kelompok }}{{ $kode_urut }}</b></label>
                                    </div>
                                </div>

                                

                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Sparepart</th>
                                                    <th>Part Desc</th>
                                                    <th>Part Standard</th>
                                                    <th>Part Name</th>
                                                    <th>S/N</th>
                                                    <th>Stock</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @forelse ($po_detail as $row)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $row->part_purchase_order_part_code }}</td>
                                                    <td>{{ $row->part_desc }}</td>
                                                    <td>{{ $row->partstandard_Desc }}</td>
                                                    <td>{{ $row->partname_desc }}</td>
                                                    <td>{{ $row->part_sn }}</td>
                                                    <td align="right">0</td>
                                                    <td align="right">{{ number_format($row->part_purchase_order_qty) }}</td>
                                                    <td align="right">Rp. {{ number_format($row->part_purchase_order_price) }}</td>
                                                    <td align="right">Rp. {{ number_format($row->part_purchase_order_qty * $row->part_purchase_order_price) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                
                                                </tr>
                                                @endforelse
                                               
                                            </tbody>
                                            <tfoot>
                                                <th colspan="8" style="text-align: center;">Total</th>
                                                <th colspan="2" style="text-align: right;">Rp. {{ number_format($po_total->total_price) }}</th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row"> 
                                   

                                </div>
                                
                                <div class="row">
                                    
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
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


