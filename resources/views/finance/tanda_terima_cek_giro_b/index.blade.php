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

@stop

@extends('layouts.admin')

@section('title')
	<title>Izin B</title>
@endsection

@section('content')

<main class="main">
    <style>
        .modal-dialog {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
        }
    
        .modal-content {
            width: 100%;
            max-width: 100%;
            height: 100%;
            border: 0;
            border-radius: 0;
        }
    </style>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item active">Izin B</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Izin B
                                <a href="{{ route('tanda_terima_b.create') }}" class="btn btn-primary btn-sm float-right">Buat Izin B</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <!-- <form action="{{ route('tanda_terima_b/cari.cari') }}" method="get">
                                <div class="row">
                                    <div class="col-md-9 mb-2">    
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group mb-2">
                                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" name="button_cari_tanggal" id="button_cari_tanggal" value="tgl">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form> -->

                            <form action="{{ route('tanda_terima_b/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">
                                    <input type="text" id="tanggal" name="tanggal" class="form-control"value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>
                            </form>

                        
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Izin</th>
                                            <th>Tgl Izin</th>
                                            <th>No Izin</th>
                                            <th>Judul Izin</th>
                                            <th>Rekening Pembayar</th>
                                            <th>Bank</th>
                                            <th>Atas Nama Rekening</th>
                                            <th hidden>No Urut</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata"> 
                                        @php $no = 1; @endphp
                                        @forelse($data_izin_b as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $val->kode_izin_b }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_izin_b)) }}</td>
                                                <td>{{ $val->no_izin_b }}</td>
                                                <td>{{ $val->judul_izin_b }}</td>
                                                <td>{{ $val->rekening_pembayar }}</td>
                                                <td>{{ $val->nama_bank }}</td>
                                                <td>{{ $val->atas_nama_rek }}</td>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td align="center">
                                                    <a href="#" class="btn btn-success btn-sm">View</a>
                                                    <a href="{{ route('tanda_terima_b/pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Cetak</a>
                                                </td>
                                            </tr> 
                                            <?php $no++ ?>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modalView" >
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="background: #fff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Izin B</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="inputNama" class="form-label">No Izin: </label> 
                        <label for="inputNama" class="form-label kode" style="font-weight: bold;"></label> 
                    </div>
                    <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Kode Seri Warkat: </label> 
                        <label for="inputNama" class="form-label seri_warkat" style="font-weight: bold;"></label>
                    </div>
                    {{-- <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Seri Awal: </label> 
                        <label for="inputNama" class="form-label seri_awal" style="font-weight: bold;"></label>
                    </div>
                    <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Seri Akhir: </label> 
                        <label for="inputNama" class="form-label seri_akhir" style="font-weight: bold;"></label>
                    </div>
                    <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Jml Lembar: </label> 
                        <label for="inputNama" class="form-label jml_lembar" style="font-weight: bold;"></label>
                    </div> --}}
                </div>
                <div class="table-responsive">
                    <div style="border:1px white;width:100%;height:550px;overflow-y:scroll;">
                        <table id="datatabel" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Cek/Giro</th>
                                    <th>Perusahaan</th>
                                    <th>Bank</th>
                                    <th>No Rekening</th>
                                    <th>Nama Vendor</th>
                                    <th>Atas nama</th>
                                    <th>Bank Vendor</th>
                                    <th>No Rekeing Vendor </th>
                                </tr>
                            </thead>
                            <tbody id="tbl_detail" class="tbl_detail">
            
                            </tbody>
                        </table>
                    </div>
                </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection