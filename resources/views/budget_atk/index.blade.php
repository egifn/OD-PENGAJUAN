@extends('layouts.admin')

@section('title')
    <title>Badget ATK</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Badget ATK</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Badget ATK
                                <a href="{{ route('budget_atk.create') }}" class="btn btn-primary btn-sm float-right">Tambah Badget</a>
                            </h4>
                        </div>

                        

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('budget_atk.index') }}" method="get">
                                <div class="input-group mb-2 col-md-4 float-right">
                                    <input type="text" name="q" id="q" class="form-control" placeholder="Cari Data..." value="{{ request()->q }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th hidden>id</th>
                                            <th hidden>KodePerusahaan</th>
                                            <th>Wilayah</th>
                                            <th hidden>Kode Depo</th>
                                            <th>Depo</th>
                                            <th hidden>Kode Divisi</th>
                                            <th>Divisi</th>
                                            <th>Badget</th>
                                            <th>[Aksi]</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        @forelse($data_budget as $val)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td hidden>{{ $val->kode_budget }}</td>
                                            <td hidden>{{ $val->kode_perusahaan }}</td>
                                            <td>{{ $val->nama_perusahaan }}</td>
                                            <td hidden>{{ $val->kode_depo }}</td>
                                            <td>{{ $val->nama_depo }}</td>
                                            <td hidden>{{ $val->kode_divisi }}</td>
                                            <td>{{ $val->nama_divisi }}</td>
                                            <td align="right">Rp. {{ number_format($val->budget) }}</td>
                                            <td align="center">
                                                <a href="{{ route('budget_atk/update.update_view', $val->kode_budget) }}" class="btn btn-warning btn-sm">Edit</a>
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


