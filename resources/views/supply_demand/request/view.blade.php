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
        <li class="breadcrumb-item">Supply Demand</li>
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item active">Request Detail</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Request</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Applicant's Name {{ $head->name }}
                                        <br>
                                        <br>
                                        PO Number {{ $head->kode_pesan }}
                                        <br>
                                        <br>
                                        Date {{ $head->tgl_pesan }}
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Factory {{ $head->kode_pabrik }}
                                        <br>
                                        <br>
                                        Company {{ $head->nama_perusahaan }}
                                        <br>
                                        <br>
                                        Depo {{ $head->nama_depo }} 
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                
                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:150px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Product Id</th>
                                                    <th>Product Name</th>
                                                    <th>Unit</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($detail as $row)
                                            <tr>
                                                <td hidden>#</td>
                                                <td>{{ $row->kode_produk}}</td>
                                                <td>{{ $row->nama_produk}}</td>
                                                <td>{{ $row->unit }}</td>
                                                <td align="right">{{ number_format($row->harga_satuan) }}</td>
                                                <td align="right">{{ number_format($row->qty) }}</td>
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
                                <br>
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


