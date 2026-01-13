
@extends('layouts.admin')

@section('title')
    <title>Jatuh Tempo Pelanggan (Daytech)</title>
@endsection

@section('content')

<main class="main">
	<link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Daftar Jatuh Tempo (Daytech)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Jatuh Tempo (Daytech)
                            </h4>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="row">
								<form action="{{ route('list_due_date_dts.listcari') }}" method="get">
									<div class="input-group mb-3 col-md-12">  
										<input type="text" id="customer" name="customer" class="form-control" placeholder="Masukan ID Toko" value="{{ request()->customer }}">

										&nbsp
										<input type="text" id="docId" name="docId" class="form-control" placeholder="Masukan Invoice" value="{{ request()->docId }}">

										&nbsp
										<input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">

										&nbsp &nbsp 

										<button class="btn btn-primary" type="submit">C a r i</button>
										&nbsp &nbsp
									</div>    
								</form>
								<form action="{{ route('list_due_date_dts.view') }}" method="post" enctype="multipart/form-data">
								@csrf
										   
									<input type="text" id="customer_ex" name="customer_ex" class="form-control" placeholder="Masukan ID Toko" value="{{ request()->customer }}" hidden>

									&nbsp
									<input type="text" id="docId_ex" name="docId_ex" class="form-control" placeholder=" Masukan Invoice" value="{{ request()->docId }}" hidden>

									&nbsp
									<input type="text" id="tanggal_ex" name="tanggal_ex" class="form-control" value="{{ request()->tanggal }}" hidden>

									<button class="btn btn-success" type="submit">E x c e l</button>
									   
								</form>
                            </div>
                            

							<div class="table-responsive">
                                    <table class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th hidden>Id</th>
                                                <th>No. Invoice</th>
                                                <th>Id Pelanggan</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Nilai Invoice</th>
                                                <th>Sisa Invoice</th>
                                                <th>Tgl Invoice</th>
                                                <th>Tgl JT</th>
                                                <th style="color">Tgl JT Baru</th>
                                                <th>Modifikasi Oleh</th>
                                                <th>Tgl Modifikasi</th>
												<th>waktu Modifikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse($list_jt as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td hidden>{{ $val->id }}</td>
                                                <td>{{ $val->doc_id }}</td>
                                                <td>{{ $val->customer_id}}</td>
                                                <td>{{ $val->customer_name}}</td>
                                                <td align="right">{{ number_format($val->amount)}}</td>
                                                <td align="right">{{ number_format($val->remain)}}</td>
                                                <td align="center">{{ $val->doc_date }}</td> 
                                                <td align="center">{{ $val->due_date }}</td>
                                                <td align="center" style="background-color: silver;">{{ $val->due_date_updated }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">{{ date('Y-m-d' , strtotime($val->created_at)) }}</td>
												<td align="center">{{ $val->time_update }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="12" class="text-center">Tidak ada data untuk saat ini</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
     
            //INISIASI DATERANGEPICKER
            $('#tanggal').daterangepicker({
               
            })
        })
    </script>
	
	<!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                    left: 3,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>
	
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


