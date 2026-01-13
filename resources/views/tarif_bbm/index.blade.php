@extends('layouts.admin')

@section('title')
    <title>Daftar Tarif BBM</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Tarif BBM</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Tarif BBM
                                <a href="{{ route('tarif_bbm.create') }}" class="btn btn-primary btn-sm float-right">Tambah Tarif BBM</a>
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
                                                <th hidden>id</th>
                                                <th hidden>Kode_dari_depo</th>
                                                <th>Dari Depo</th>
                                                <th>Tujuan Depo</th>
                                                <th hidden>Kode_ke_depo</th>
                                                <th>Kendaraan</th>
                                                <th>Uang Bensin</th>
                                                <th hidden>id_user</th>
                                                <th hidden>Nama Pengguna</th>
                                                <th>[Aksi]</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @forelse($data_tarif_bbm as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td hidden>{{ $val->id }}</td>
                                                <td hidden>{{ $val->kd_dari_depo }}</td>
                                                <td>{{ $val->dari_depo }}</td>
                                                <td hidden>{{ $val->kd_ke_depo }}</td>
                                                <td>{{ $val->ke_depo }}</td>
                                                <td>{{ $val->kendaraan }}</td>
                                                <td align="right">{{ $val->uang }}</td>
                                                <td hidden>{{ $val->id_user_input }}</td>
                                                <td hidden>{{ $val->name }}</td>
                                                <td align="center">
                                                    <a href="{{ route('tarif_bbm/update.update_view', $val->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
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


