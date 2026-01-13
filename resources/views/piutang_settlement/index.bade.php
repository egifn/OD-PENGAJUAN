
@extends('layouts.admin')

@section('title')
    <title>Settlement</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Settlement</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row"> 
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Settlement
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="get">
                                <div class="row">
                                    <div class="input-group mb-3 col-md-8">  
                                        
                                    </div>

                                    <div class="input-group mb-3 col-md-4">  
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                        &nbsp
                                        <button class="btn btn-secondary" type="submit">C a r i</button>
                                    </div>    
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:60%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th hidden>id</th>
                                            <th>No Cek</th>
                                            <th>Nominal</th>
                                            <th hidden>Jatuh Tempo</th>
                                            <th hidden>Id Pelanggan</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Bank</th>
                                            <th hidden>Status Cek</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">                  
                                <div class="col-md-12 mb-2">
                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-primary btn-sm float-right">Approval</button>
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

@section('js')
    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v2').DataTable({
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
                    left: 3,
                    right: 1,
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

    <script type="text/javascript">
        


    </script>



@endsection