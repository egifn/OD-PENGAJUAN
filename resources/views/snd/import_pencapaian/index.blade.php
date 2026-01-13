@extends('layouts.admin')

@section('title')
    <!-- <title>Import Data DMS</title> -->
    <title>Import Pencapaian Program</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Pencapaian Program</li>
        <li class="breadcrumb-item active">Daftar Pencapaian</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Import Pencapaian Program
                                <a href="{{ route('import_pencapaian.create') }}" class="btn btn-warning btn-sm float-right">Import File</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('import_pencapaian/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Id</th>
                                                <th>Tgl Import</th>
                                                <th>Keterangan</th>
                                                <th>No Surat</th>
												<th>Id Program</th>
                                                <th>Nama Program</th>
                                                <th>Perusahaan</th>
												<th>Status</th>
                                                <th hidden>Id User Input</th>
                                                <th hidden>Nama User Input</th>
                                                <th hidden>No Urut</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse ($data as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td hidden></td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_import)) }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td>{{ $val->no_surat }}</td>
												<td>{{ $val->id_program}}</td>
                                                <td>{{ $val->nama_program }}</td>
                                                <td>{{ $val->kode_perusahaan }}</td>
												<td align="center">
                                                    @if($val->status == '0')
                                                        <label class="badge badge-success">Send</label> 
                                                    @elseif($val->status == '3') 
														<a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending (revision from Claim)</a>
                                                    @endif
                                                </td>
                                                <td hidden>{{ $val->id_user_input }}</td>
                                                <td hidden></td>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td align="center">
                                                    @if($val->status == '3')
                                                        <a href="{{ route('import_pencapaian/update_data', $val->no_urut) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    @endif
                                                    <a href="{{ route('import_pencapaian.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
											<!-- Modal Keterangan -->
                                            <div class="modal fade" id="modalKet{{ $val->no_urut }}" tabindex="-1" aria-labelledby="modalKet" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="#" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label>Keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" value= "{{ $val->keterangan_detail_clm }}">{{ $val->keterangan_detail_clm }}</textarea>
                                                                </div>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal Keterangan -->
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data yang tersedia</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            {{-- {!! $data->links() !!} --}}
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

