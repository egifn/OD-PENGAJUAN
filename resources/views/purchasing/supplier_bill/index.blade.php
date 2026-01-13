@extends('layouts.admin')

@section('title')
    <title>Tagihan Vendor</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item active">Tagihan Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Tagihan Vendor
                            </h4>
                        </div>
                        <!-- Panel/Tab
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <h3>HOME</h3>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <h3>Profile</h3>
                                        </div>
                                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                            <h3>Contact</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         -->

                        
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('supplier_bill/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <select name="type" class="form-control" hidden>
                                        <option value="{{ request()->type }}">Type</option>
                                        <option value="Non Sparepart">Non Sparepart</option>
                                        <option value="Sparepart">Sparepart</option>
                                    </select>
                                    &nbsp
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>     
                            </form>

                            <div class="table-responsive">
                              
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Kontrabon</th>
                                                <th>Tanggal</th>
                                                <th hidden>Vendor ID</th>
                                                <th>Vendor</th>
                                                <th hidden>Type</th>
                                                <th>Total</th>
                                                <th>Cek/Giro</th>
                                                <th>Status</th>
                                                <th>Input By</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($supplier_bill as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->no_kontrabon }}</td>
                                                <td>{{ $val->tgl_kontrabon }}</td>
                                                <td hidden>{{ $val->kode_vendor }}</td>
                                                <td>{{ $val->nama_vendor }}</td>
                                                <td hidden>{{ $val->type }}</td>
                                                <td align="right">{{ number_format($val->total) }}</td>
                                                <td align="center"><b>{{ $val->id_cek }}</b></td>
                                                <td align="center">
                                                     @if($val->status == '0' || $val->status == '1')
                                                        <label class="badge badge-secondary">Process</label>
                                                     @elseif($val->status == '2')
                                                        <label class="badge badge-primary">Send</label>
                                                     @elseif($val->status == '3')
                                                        <label class="badge badge-success">Done</label>
                                                     @endif
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    @if($val->status == '0' || $val->status == '1')
                                                        <button onClick="alert('Checks/Giro in progress')" class="btn btn-primary btn-sm">Bayar</button>
                                                    @elseif($val->status == '2')
                                                        <a href="{{ route('supplier_bill.view', $val->no_kontrabon) }}" class="btn btn-primary btn-sm">Bayar</a>
                                                    @elseif($val->status == '3')
                                                        <button class="btn btn-secondary btn-sm" disabled>Bayar</button>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
@endsection