
@extends('layouts.admin')

@section('title')
    <title>Format Surat</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Surat Program</li>
        <li class="breadcrumb-item">Eksternal</li>
        <li class="breadcrumb-item active">Format Surat</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Format Surat Program
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalBuatFormat">
                                    Buat Format
                                </button>
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
                                
                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>Id</th>
                                                <th>kode Perusahaan</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Kepala Judul</th>
                                                <th>Kepala Alamat</th>
                                                <th>Kepada</th>
                                                <th>Alamat Tujuan 1</th>
                                                <th>Alamat Tujuan 2</th>
                                                <th>Alamat Tujuan 3</th>
                                                <th>Prihal</th>
                                                <th>Up</th>
                                                <th>Isi 1</th>
                                                <th>Isi 2</th>
                                                <th>Penutup</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($format_surat as $val)
                                            <tr>
                                                <td hidden>{{ $val->id}}</td>
                                                <td>{{ $val->kode_perusahaan }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td>{{ $val->header_judul }}</td>
                                                <td>{{ $val->header_alamat }}</td>
                                                <td>{{ $val->kepada }}</td>
                                                <td>{{ $val->alamat_tujuan_1 }}</td>
                                                <td>{{ $val->alamat_tujuan_2}}</td>
                                                <td>{{ $val->alamat_tujuan_3}}</td>
                                                <td>{{ $val->prihal}}</td>
                                                <td>{{ $val->up}}</td>
                                                <td>{{ $val->isi_1}}</td>
                                                <td>{{ $val->isi_2}}</td>
                                                <td>{{ $val->penutup}}</td>
                                                <td>
                                                    <!-- <button type="button" id="view_app" value="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">View Apprvd</button> -->
                                                    <a href="#" class="btn btn-warning btn-sm">Update</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="14" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalBuatFormat" tabindex="-1" aria-labelledby="modalBuatFormat" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Isi Format</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('format_surat_program_eks/simpan.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Kode Perusahaan</label>
                        <select id="kode_perusahaan" name="kode_perusahaan" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="WPS">WENANG PALM SOLUSINDO</option>
                            <option value="LP">LOKON PRIMA</option>
                            <option value="TUA">TIRTA UTAMA ABADI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Header Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Header Alamat</label>
                        <input type="text" class="form-control" id="h_alamat" name="h_alamat" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Kepada</label>
                        <input type="text" class="form-control" id="kepada" name="kepada" value="">
                    </div>
                    
                    <div class="form-group">
                        <label for="">Alamat Tujuan 1</label>
                        <input type="text" class="form-control" id="alamat_1" name="alamat_1">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Tujuan 2</label>
                        <input type="text" class="form-control" id="alamat_2" name="alamat_2">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Tujuan 3</label>
                        <input type="text" class="form-control" id="alamat_3" name="alamat_3">
                    </div>

                    <div class="form-group">
                        <label for="">Prihal</label>
                        <input type="text" class="form-control" id="prihal" name="prihal">
                    </div>
                    <div class="form-group">
                        <label for="">Up</label>
                        <input type="text" class="form-control" id="up" name="up">
                    </div>

                    <div class="form-group">
                        <label for="">Isi 1</label>
                        <input type="text" class="form-control" id="isi" name="isi">
                    </div>
                    <div class="form-group">
                        <label for="">Isi 2</label>
                        <input type="text" class="form-control" id="isi_2" name="isi_2">
                    </div>

                    <div class="form-group">
                        <label for="">Penutup</label>
                        <input type="text" class="form-control" id="penutup" name="penutup">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                </form>
                <!--END FORM TAMBAH BARANG-->
            </div>
        </div>
    </div>
</div>
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
                    left: 2,
                    right: 1,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>
    

@endsection