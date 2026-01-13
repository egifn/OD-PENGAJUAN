@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Aceppted Detail</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Aceppted</li>
        <li class="breadcrumb-item active">View</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Aceppted Detail (View)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">Invoice Number : <b>{{ $invoice->no_faktur }}</b></label>
                                    </div>
                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="supplier">Vendor : <b>{{ $invoice->nama_vendor }}</b></label>
                                    </div>

                                    
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Date : <b>{{ $invoice->tgl_faktur }}</b></label>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Address : <b>{{ $invoice->alamat }}</b></label>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">PO Number : <b>{{ $invoice->kode_pembelian }}</b></label>
                                    </div>
                                </div>

                                <br>

                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Product Id</th>
                                                    <th>Product Name</th>
                                                    <th>Merk</th>
                                                    <th>Desc/Spek</th>
                                                    <th hidden>Harga</th>
                                                    <th>Qty</th>
                                                    <th hidden>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($invoice_detail as $val)
                                                <tr>
                                                    <td hidden></td>
                                                    <td>{{ $val->kode_product }}</td>
                                                    <td>{{ $val->nama_barang}}</td>
                                                    <td>{{ $val->merk }}</td>
                                                    <td>{{ $val->ket }}</td>
                                                    <td align="right" hidden>{{ number_format($val->price) }}</td>
                                                    <td align="right">{{ $val->qty_terima }}</td>
                                                    <td align="right" hidden>{{ number_format($val->price * $val->qty_terima) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-10 mb-2" hidden>
                                        
                                        <label for="supplier" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                        
                                    </div>  
                                    <div class="col-md-2 mb-2" hidden>
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ number_format($invoice->total) }}" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div>

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


