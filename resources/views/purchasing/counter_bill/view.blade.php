@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Invoice Detail</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Counter Bill</li>
        <li class="breadcrumb-item">Create Counter Bill</li>
        <li class="breadcrumb-item active">Invoice Detail</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Invoice Detail (View)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">No. Invoice : <b>{{ $invoice->no_faktur }}</b></label>
                                    </div>
                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="supplier">Supplier : <b>{{ $invoice->nama_vendor }}</b></label>
                                    </div>

                                    
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Tanggal : <b>{{ $invoice->tgl_faktur }}</b></label>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Alamat : <b>{{ $invoice->alamat }}</b></label>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">No. PO : <b>{{ $invoice->kode_pembelian }}</b></label>
                                    </div>
                                </div>

                                <br>

                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Kode Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Keterangan/Spek</th>
                                                    <th>Harga</th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
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
                                                    <td align="right">{{ number_format($val->price) }}</td>
                                                    <td align="right">{{ $val->qty_terima }}</td>
                                                    <td align="right">{{ number_format($val->price * $val->qty_terima) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-10 mb-2">
                                        
                                        <label for="supplier" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                        
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ number_format($invoice->total) }}" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div>

                                </div>
                                
                                <div class="row" hidden>
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


