@extends('layouts.admin')

@section('title')
    <title>Bayar Tagihan Vendor</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Tagihan Vendor</li>
        <li class="breadcrumb-item active">Bayar Tagihan Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Bayar Tagihan Vendor
                            </h4>
                        </div>
                        
                        <div class="card-body">
                        <form action="{{ route('supplier_bill.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-1 mb-2">
                                    <input type="hidden" name="no_kontrabon" id="no_kontrabon" class="form-control" value="{{ $bayar->no_kontrabon }}" >
                                </div>
                                <div class="col-md-2 mb-2">
                                    No Kontrabon
                                </div>
                                <div class="col-md-3 mb-2">
                                    : {{ $bayar->no_kontrabon }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 mb-2">
                                    
                                </div>
                                <div class="col-md-2 mb-2">
                                    Nama Vendor 
                                </div>
                                <div class="col-md-6 mb-2">
                                    : {{ $bayar->nama_vendor}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 mb-2">
                                    
                                </div>
                                <div class="col-md-2 mb-2">
                                    No Cek/Giro 
                                </div>
                                <div class="col-md-6 mb-2">
                                    : {{ $bayar->id_cek}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 mb-2">
                                    
                                </div>
                                <div class="col-md-2 mb-2">
                                    Jumlah 
                                </div>
                                <div class="col-md-3 mb-2">
                                    : <b>Rp. {{ number_format($bayar->total) }}</b>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1 mb-2">
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1 mb-2">
                                    
                                </div>
                            </div>

                            <p>

                            <div class="row">
                                <div class="col-md-1 mb-2">
                                    
                                </div>
                                <div class="col-md-4 mb-2">
                                    Yang Menerima 
                                    <div class="input-group">
                                        <input type="text" name="penerima" id="penerima" class="form-control" value="" >
                                         &nbsp;
                                        <button class="btn btn-primary btn-sm float-right">B a y a r</button>
                                    </div>    
                                </div>
                                    
                                </div>
                            </div>
                        </form>
                              
                        </div>
                        


                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection

