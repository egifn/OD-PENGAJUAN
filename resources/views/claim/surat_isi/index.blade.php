
@extends('layouts.admin')

@section('title')
    <title>Format Surat</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Surat</li>
        <li class="breadcrumb-item active">Buat Surat</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Buat Surat
                                <a href="{{ route('isi_surat.create') }}" class="btn btn-primary btn-sm float-right">Buat Surat</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('isi_surat/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                
                                    <table class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>kode Surat</th>
                                                <th>Tanggal</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Prihal</th>
                                                <th>Total</th>
                                                <th>User</th>
                                                <th hidden>No_urut</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse($surat as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $val->kode_surat }}</td>
                                                <td>{{ $val->tanggal }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td>{{ $val->prihal }}</td>
                                                @if($val->jenis == 'Rupiah' || $val->jenis == '')
                                                    <td align="right">Rp. {{  number_format($val->total) }}</td>
                                                @else
                                                    <td align="right">{{  ($val->total) }} Box</td>
                                                @endif
                                                
                                                <td>{{ $val->name }}</td>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td align="center">
                                                    <!-- <button type="button" id="view_app" value="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">View Apprvd</button> -->
                                                    <a href="{{ route('isi_surat/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">view</a>
                                                    <a href="{{ route('isi_surat/update.update', $val->no_urut) }}" class="btn btn-warning btn-sm">Edit</a>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" align="center" bgcolor="#E6E6E6"><b>Jumlah Total<b></td>
                                                <td colspan="3" align="center" bgcolor="#E6E6E6"><b>Rp. {{ number_format($sub_total->sub_total) }}<b></td>
                                            </tr>
                                        </tfoot>
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
                <form action="{{ route('format_surat/simpan.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Kode Perusahaan</label>
                        <select id="kode_perusahaan" name="kode_perusahaan" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="TA">TIRTA ANGKASA</option>
                            <option value="TU">TIRTA USAHA</option>
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