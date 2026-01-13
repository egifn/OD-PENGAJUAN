@extends('layouts.admin')

@section('title')
    <title>Daftar Pengguna</title>
@endsection

@section('content')

<main class="main">
	<link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
	
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Daftar Pengguna</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Pengguna
                                <a href="{{ route('user_registration.create') }}" class="btn btn-primary btn-sm float-right">Tambah Pengguna</a>
                            </h4>
                        </div>

                        

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="get" hidden>
                                <div class="input-group mb-3 col-md-6">  
                                    
                                    <input type="text" id="customer" name="customer" class="form-control" placeholder="Masukan ID Toko" value="{{ request()->customer }}" hidden>

                                    &nbsp
                                    <input type="text" id="docId" name="docId" class="form-control" placeholder=" Masukan Invoice" value="{{ request()->docId }}" hidden>

                                <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}" hidden>
                                    &nbsp
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>   
                            </form>


                            
                            <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
								<div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Id Pengguna</th>
                                                <th>Nama Pengguna</th>
                                                <th>User</th>
                                                <th>Perusahaan</th>
                                                <th>Divisi</th>
                                                <th>Tipe Pengguna</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse ($pengguna as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td hidden>{{ $val->id }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td>{{ $val->username }}</td>
                                                <td>{{ $val->kode_perusahaan }}</td>
                                                <td>{{ $val->nama_divisi }}</td>
												<td>{{ $val->type }}</td>
                                                <td align="center">
                                                    @if($val->status_user == 'Aktif')
                                                        <label class="badge badge-success">Aktif</label>
                                                    @elseif($val->status_user == 'Tidak Aktif')
                                                        <label class="badge badge-danger">Tidak Aktif</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @if(Auth::user()->kode_divisi == '23') <!-- Jika Korsis-->
                                                        <a href="{{ route('user_registration/update.update_view', $val->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    @else
                                                        <a href="{{ route('user_registration/update.update_view', $val->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data</td>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(document).ready(function() {
            //INISIASI DATERANGEPICKER
            $('#tanggal').datepicker({
               format: 'mm-dd-yyyy'
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
                scrollY: "355px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

    

@endsection


