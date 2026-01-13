@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Request Detail</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item active">Pembelian Detail</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pembelian (View)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="kode">Kode Pembelian : <b>{{ $pembelian_v->kode_pembelian }}</b></label>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="supplier">Vendor : <b>{{ $pembelian_v->nama_vendor }}</b></label>
                                    </div>

                                    
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="tgl">Tgl Pembelian : <b>{{ $pembelian_v->tgl_pembelian }}</b></label>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Alamat : <b>{{ $pembelian_v->alamat }}</b></label>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2 float-right">
                                        <label for="nama">Pengajuan Oleh : <b>{{ $pembelian_v->name }} (PT. TIRTA UTAMA ABADI)</b></label>
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
                                                    <th>Jml</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($detail as $row)
                                                <tr>
                                                    <td hidden>#</td>
                                                    <td>{{ $row->kode_product }}</td>
                                                    <td>{{ $row->nama_barang }}</td>
                                                    <td>{{ $row->merk }}</td>
                                                    <td>{{ $row->ket }}</td>
                                                    <td align="right">{{ number_format($row->harga_satuan) }}</td>
                                                    <td align="right">{{ $row->qty_po }}</td>
                                                    <td align="right">{{ number_format($row->harga_total) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                
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
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ number_format($total_jml) }}" style="text-align:right; font-style:bold;" required readonly>
                                        
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


