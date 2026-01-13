@extends('layouts.admin')

@section('title')
    <title>Jatuh Tempo (Alfred)</title>
@endsection

@section('content')

<main class="main">

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Accounting</li>
        <li class="breadcrumb-item active">Jatuh Tempo (Alfred)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Jatuh Tempo (Alfred)
                            </h4>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('duedate_alfred.duedatecari') }}" method="get">
                                <div class="input-group mb-3 col-md-6">  
                                    
                                    <input type="text" id="customer" name="customer" class="form-control" placeholder="Masukan ID Toko" value="{{ request()->customer }}">

                                    &nbsp
                                    <input type="text" id="docId" name="docId" class="form-control" placeholder=" Masukan Invoice" value="{{ request()->docId }}">

									<!-- <input type="text" id="tanggal" name="tanggal" class="form-control" > -->
                                    &nbsp
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>   
                            </form>


                            
                            <form action="{{ route('due_date_alfred_simpan.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf

                                <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Simpan Jatuh Tempo</button>
                                <br>
                                <div class="table-responsive">
                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Invoice</th>
                                                <th>Id Pelanggan</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Nilai Invoice</th>
                                                <th>Sisa Invoice</th>
                                                <th>Tgl Invoice</th>
                                                <th>Tgl JT</th>
                                                <th>Tgl JT Baru</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse($jt as $val)
                                            <?php $dtmDoc = date('Y-m-d', strtotime($val->dtmDoc)) ?>
                                            <?php $duedate = date('Y-m-d', strtotime($val->dtmDue)) ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>
                                                    <input type="text" class="form-control" name="szDocId[]" id="szDocId" value="{{ $val->szDocId }}" hidden>{{ $val->szDocId }}
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="customer_id[]" id="customer_id" value="{{ $val->szCustomerId }}" hidden>{{ $val->szCustomerId}}</td>
                                                <td>
                                                    <input type="text" class="form-control" name="customer_name[]" id="customer_name" value="{{ $val->szName }}" hidden>{{ $val->szName}}</td>
                                                <td align="right">
                                                    <input type="text" class="form-control" name="amount[]" id="amount" value="{{ $val->decAmount }}" hidden>{{ number_format($val->decAmount)}}</td>
                                                <td align="right">
                                                    <input type="text" class="form-control" name="remain[]" id="remain" value="{{ $val->decRemain }}" hidden>{{ number_format($val->decRemain)}}</td>
                                                <td>
                                                    <input type="text" class="form-control" name="dtm_doc[]" id="dtm_doc" value="{{ $dtmDoc }}" hidden>{{ $dtmDoc }}</td> 
                                                <td>
                                                    <input type="text" class="form-control" name="dtm_due[]" id="dtm_due" value="{{ $duedate }}" hidden>{{ $duedate }}</td>
                                                <td>
                                                    <input type="text" class="form-control" name="tanggal[]" id="tanggal{{ $no }}" placeholder="Masukan Tanggal JT" style="width: 150px;">
                                                </td>
                                                
                                            </tr>
                                            <?php $no++ ?>

                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data yang ditemukan</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            

                            
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            var tabel = document.getElementById("datatabel-v1");
            for(var t = 1; t < tabel.rows.length; t++){
                $('#tanggal'+t+'').datepicker({
                    dateFormat: 'yy-mm-dd',//check change
                    changeMonth: true,
                    changeYear: true
                });
            }        
        });
    </script>
@endsection


