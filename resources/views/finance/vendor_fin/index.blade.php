@section('js')

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
                scrollY: "356px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    leftColumns: 3,
                    rightColumns: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Vendor</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item active">Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Vendor
                                <a href="{{ route('vendor_fin.create') }}" class="btn btn-primary btn-sm float-right">Tambah Vendor</a>

                                <a href="{{ route('vendor_fin_import.index') }}" class="btn btn-warning btn-sm float-right" hidden>Import Data</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <!-- <div style="width:400%;">-->
                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th style="white-space: nowrap;" hidden>#</th>
                                                <th style="white-space: nowrap;">Kode</th>
                                                <th style="white-space: nowrap;">Vendor</th>
                                                <th style="white-space: nowrap;">Alamat</th>
                                                <th style="white-space: nowrap;">Telepon</th>
                                                <th style="white-space: nowrap;">Fax</th>
                                                <th style="white-space: nowrap;">Email</th>
                                                <th style="white-space: nowrap;">Atas Nama</th>
                                                <th style="white-space: nowrap;">Posisi</th>
                                                <th style="white-space: nowrap;" hidden>Kode Bank</th>
                                                <th style="white-space: nowrap;" hidden>Bank</th>
                                                <th style="white-space: nowrap;" hidden>No Account</th>
                                                <th style="white-space: nowrap;" hidden>Nama Account</th>
                                                <th style="white-space: nowrap;">Pajak</th>
                                                <th style="white-space: nowrap;">Tgl Mulai</th>
                                                <th style="white-space: nowrap;">Tgl Akhir</th>
                                                <th style="white-space: nowrap;">TOP</th>
                                                <th style="white-space: nowrap;">Status 1</th>
                                                <th style="white-space: nowrap;">Status 2</th>
                                                <th style="white-space: nowrap;">Memo</th>
                                                <th style="white-space: nowrap;">Tgl Memo</th>
                                                <th style="white-space: nowrap;">Disetujui Oleh</th>
                                                <th style="white-space: nowrap;">Tgl Approved</th>
                                                <th style="white-space: nowrap;">Informasion</th>
                                                <th style="white-space: nowrap;">Tgl Buat</th>
                                                <th style="white-space: nowrap;">Admin</th>
                                                <th style="white-space: nowrap;">Tgl Ubah</th>
                                                <th style="white-space: nowrap;">Diubah Oleh</th>
                                                <th style="white-space: nowrap;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($vendor as $val)
                                            <tr>
                                                <td hidden>#</td>
                                                <td style="white-space: nowrap;">{{ $val->kode_vendor }}</td>
                                                <td style="white-space: nowrap;">{{ $val->nama_vendor }}</td>
                                                <td style="white-space: nowrap;">{{ $val->alamat }}</td>
                                                <td style="white-space: nowrap;">{{ $val->telp }}</td>
                                                <td style="white-space: nowrap;">{{ $val->fax }}</td>
                                                <td style="white-space: nowrap;">{{ $val->email }}</td>
                                                <td style="white-space: nowrap;">{{ $val->contact_person }}</td>
                                                <td style="white-space: nowrap;">{{ $val->jabatan }}</td>
                                                <td style="white-space: nowrap;" hidden></td>
                                                <td style="white-space: nowrap;" hidden></td>
                                                <td style="white-space: nowrap;" hidden></td>
                                                <td style="white-space: nowrap;" hidden></td>
                                                <td style="white-space: nowrap;">-</td> <!-- pajak -->
                                                <td style="white-space: nowrap;">{{ $val->tgl_mulai }}</td>
                                                <td style="white-space: nowrap;">{{ $val->tgl_selesai }}</td>
                                                <td style="white-space: nowrap;">{{ $val->top }}</td>
                                                <td style="white-space: nowrap;">{{ $val->status_1 }}</td>
                                                <td style="white-space: nowrap;">{{ $val->status_2 }}</td>
                                                <td style="white-space: nowrap;">{{ $val->memo }}</td>
                                                <td style="white-space: nowrap;">{{ $val->tgl_memo }}</td>
                                                <td style="white-space: nowrap;">{{ $val->approved_by }}</td>
                                                <td style="white-space: nowrap;">{{ $val->tgl_approved }}</td>
                                                <td style="white-space: nowrap;">{{ $val->keterangan }}</td>
                                                <td style="white-space: nowrap;">{{ $val->created_at }}</td>
                                                <td style="white-space: nowrap;">{{ $val->name }}</td>
                                                <td style="white-space: nowrap;">{{ $val->updated_at }}</td>
                                                <td style="white-space: nowrap;">{{ $val->id_user_update }}</td>
                                                <td style="white-space: nowrap;">
                                                    <form action="{{ route('vendor_fin.destroy', $val->kode_vendor) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('vendor_fin.edit', $val->kode_vendor) }}" class="btn btn-warning btn-sm">Ubah</a>
                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="28" class="text-center">No data available</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                <!-- </div> -->
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
   
@endsection