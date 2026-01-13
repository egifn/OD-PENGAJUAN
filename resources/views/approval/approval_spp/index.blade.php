@extends('layouts.admin')

@section('title')
    <title>Approval SPP</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item active">Approval SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Approval SPP
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12 mb-4">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#pengajuan" role="tab" aria-controls="pengajuan">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>SPP Pengajuan</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#manual" role="tab" aria-controls="manual">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>SPP Manual</b>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="pengajuan" role="tabpanel"> 
                                        <div class="card-body">
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('approval_spp/cari.cari') }}" method="get">
                                                <div class="input-group mb-3 col-md-4 float-right">  
                                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                                    &nbsp
                                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                                </div> 
                                                <div class="input-group mb-3 col-md-4">  
                                                    <input type="text" name="search_pengajuan" id="search_pengajuan" class="form-control" placeholder="Cari kode pengajuan / no SPP / keterangan...">
                                                </div>   
                                            </form>

                                            <div class="table-responsive">
                                                <!-- <table class="table table-hover table-bordered"> -->
                                                <div style="width:100%;">
                                                    <table class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th hidden>No</th>
                                                                <th>Kode Pengajuan</th>
                                                                <th>Tgl Pengajuan</th>
                                                                <th style="width: 250px;">Keterangan</th>
                                                                <th>No SPP</th>
                                                                <th>Tgl SPP</th>
                                                                <th>Nilai SPP</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table_pengajuan">
                                                            @forelse($approval_spp as $val)
                                                                @if(Auth::user()->kode_sub_divisi == '5') <!-- Manager Biaya Acc -->
                                                                    <tr>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                        <td>{{ $val->kode_pengajuan_b }}</td>
                                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                                        <td style="width: 250px;">{{ $val->keterangan }}</td>
                                                                        <td>{{ $val->no_spp }}</td>
                                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_spp)) }}</td>
                                                                        <td align="right">{{ number_format($val->jumlah) }}</td>
                                                                        <td align="center">
                                                                            @if($val->status_spp_1 == '0')
                                                                                <label class="badge badge-secondary">New</label>
                                                                            @elseif($val->status_spp_1 == '1')
                                                                                <label class="badge badge-success">Approved</label>
                                                                            @elseif($val->status_spp_1 == '2')
                                                                                <label class="badge badge-danger">Denied</label>
                                                                            @elseif($val->status_spp_1 == '3')
                                                                                <label class="badge badge-warning">Pending</label>
                                                                            @endif
                                                                        </td>
                                                                        <td align="center">
                                                                            <a href="{{ route('approval_spp.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                        </td>
                                                                    </tr>
                                                                @elseif(Auth::user()->kode_sub_divisi == '4') <!-- Manager Acc -->
                                                                    <tr>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                        <td>{{ $val->kode_pengajuan_b }}</td>
                                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                                        <td>{{ $val->keterangan }}</td>
                                                                        <td>{{ $val->no_spp }}</td>
                                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_spp)) }}</td>
                                                                        <td align="right">{{ number_format($val->jumlah) }}</td>
                                                                        <td align="center">
                                                                            @if($val->status_spp_2 == '0')
                                                                                <label class="badge badge-secondary">New</label>
                                                                            @elseif($val->status_spp_2 == '1')
                                                                                <label class="badge badge-success">Approved</label>
                                                                            @elseif($val->status_spp_2 == '2')
                                                                                <label class="badge badge-danger">Denied</label>
                                                                            @elseif($val->status_spp_2 == '3')
                                                                                <label class="badge badge-warning">Pending</label>
                                                                            @endif
                                                                        </td>
                                                                        <td align="center">
                                                                            <a href="{{ route('approval_spp.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="manual" role="tabpanel">
                                        <div class="card-body">
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('approval_spp/cari.cari') }}" method="get">
                                                <div class="input-group mb-3 col-md-4 float-right">  
                                                    <input type="text" id="tanggal_manual" name="tanggal_manual" class="form-control" value="{{ request()->tanggal_manual }}">
                                                    &nbsp
                                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                                </div>  
                                                
                                                <div class="input-group mb-3 col-md-4">  
                                                    <input type="text" name="search_manual" id="search_manual" class="form-control" placeholder="Cari kode / no SPP / keterangan...">
                                                </div>
                                            </form>

                                            <div class="table-responsive">
                                                <!-- <table class="table table-hover table-bordered"> -->
                                                <div style="width:100%;">
                                                    <table class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th hidden>No</th>
                                                                <th>Tgl Pengajuan</th>
                                                                <th>Keterangan</th>
                                                                <th>No SPP</th>
                                                                <th>Tgl SPP</th>
                                                                <th>Nilai SPP</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table_manual">
                                                            @forelse($data as $man)
                                                                @if(Auth::user()->kode_sub_divisi == '5') <!-- Manager Biaya Acc -->
                                                                    <tr>
                                                                        <td hidden></td>
                                                                        <td>{{ date('d-M-Y', strtotime($man->tgl_spp)) }}</td>
                                                                        <td>{{ $man->keterangan }}</td>
                                                                        <td>{{ $man->no_spp }}</td>
                                                                        <td>{{ date('d-M-Y', strtotime($man->tgl_spp)) }}</td>
                                                                        <td align="right">{{ number_format($man->jumlah) }}</td>
                                                                        <td align="center">
                                                                            @if($man->status_spp_1 == '0')
                                                                                <label class="badge badge-secondary">New</label>
                                                                            @elseif($man->status_spp_1 == '1')
                                                                                <label class="badge badge-success">Approved</label>
                                                                            @elseif($man->status_spp_1 == '2')
                                                                                <label class="badge badge-danger">Denied</label>
                                                                            @elseif($man->status_spp_1 == '3')
                                                                                <label class="badge badge-warning">Pending</label>
                                                                            @endif
                                                                        </td>
                                                                        <td align="center">
                                                                            <a href="{{ route('approval_spp_manual.view_manual', $man->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                        </td>
                                                                    </tr>
                                                                @elseif(Auth::user()->kode_sub_divisi == '4') <!-- Manager Acc -->
                                                                    <tr>
                                                                        <td hidden>{{ $man->no_urut }}</td>
                                                                        <td>{{ date('d-M-Y', strtotime($man->tgl_spp)) }}</td>
                                                                        <td>{{ $man->keterangan }}</td>
                                                                        <td>{{ $man->no_spp }}</td>
                                                                        <td>{{ date('d-M-Y', strtotime($man->tgl_spp)) }}</td>
                                                                        <td align="right">{{ number_format($man->jumlah) }}</td>
                                                                        <td align="center">
                                                                            @if($man->status_spp_2 == '0')
                                                                                <label class="badge badge-secondary">New</label>
                                                                            @elseif($man->status_spp_2 == '1')
                                                                                <label class="badge badge-success">Approved</label>
                                                                            @elseif($man->status_spp_2 == '2')
                                                                                <label class="badge badge-danger">Denied</label>
                                                                            @elseif($man->status_spp_2 == '3')
                                                                                <label class="badge badge-warning">Pending</label>
                                                                            @endif
                                                                        </td>
                                                                        <td align="center">
                                                                            <a href="{{ route('approval_spp_manual.view_manual', $man->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                                        </div>
                                    </div>
                                </div>
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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        
        $(document).ready(function() {
            //INISIASI DATERANGEPICKER
            $('#tanggal').daterangepicker({
               
            })

            $('#tanggal_manual').daterangepicker({
               
            })
        })
    </script>

    <script>
        function formatTanggal(tanggal) {
            if (!tanggal) return '';
            const date = new Date(tanggal);
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            return date.toLocaleDateString('id-ID', options); // contoh: 24 Okt 2025
        }

        function formatRupiah(angka) {
            if (!angka) return '0';
            return parseFloat(angka).toLocaleString('id-ID');
        }

        

        $("#search_pengajuan").keyup(function() {
            let value = $("#search_pengajuan").val();
            if (this.value.length >= 2) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('approval_spp.search') }}",
                    data: {
                        value: value
                    },
                    dataType: "json",
                    success: function(response) {
                        let table_pengajuan;
                        // let no = 1;
                        response.data.forEach(rek => {
                            table_pengajuan += `<tr>`;
                                table_pengajuan += `<td hidden>${rek.no_urut}</td>`;
                                table_pengajuan += `<td>${rek.kode_pengajuan_b}</td>`;
                                table_pengajuan += `<td>${formatTanggal(rek.tgl_pengajuan_b)}</td>`;
                                table_pengajuan += `<td>${rek.keterangan ?? ''}</td>`;
                                table_pengajuan += `<td>${rek.no_spp ?? ''}</td>`;
                                table_pengajuan += `<td>${formatTanggal(rek.tgl_spp)}</td>`;
                                table_pengajuan += `<td align="right">${formatRupiah(rek.jumlah)}</td>`;
                                table_pengajuan += `<td align="center">`;

                                if (rek.status_spp_1 == 0) {
                                    table_pengajuan += `<label class="badge badge-secondary">New</label>`;
                                } else if (rek.status_spp_1 == 1) {
                                    table_pengajuan += `<label class="badge badge-success">Approved</label>`;
                                } else if (rek.status_spp_1 == 2) {
                                    table_pengajuan += `<label class="badge badge-danger">Denied</label>`;
                                } else if (rek.status_spp_1 == 3) {
                                    table_pengajuan += `<label class="badge badge-warning">Pending</label>`;
                                }

                                table_pengajuan += `</td>`;
                                table_pengajuan += `<td align="center"><a href="/approval_spp/view/\${rek.no_urut}" class="btn btn-primary btn-sm">View</a></td>`;

                                
                            table_pengajuan += `</tr>`;

                        });
                        $("#table_pengajuan").html(table_pengajuan);
                    }
                });
            }else{
               
            }
        });

        

        $("#search_manual").keyup(function() {
            let value = $("#search_manual").val();
            if (this.value.length >= 2) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('approval_spp.search_manual') }}",
                    data: {
                        value: value
                    },
                    dataType: "json",
                    success: function(response) {
                        let table_manual;
                        // let no = 1;
                        response.data.forEach(rek => {
                            table_manual += `<tr>`;
                                table_manual += `<td hidden>${rek.no_urut}</td>`;
                                table_manual += `<td>${formatTanggal(rek.tgl_spp)}</td>`;
                                table_manual += `<td>${rek.keterangan ?? ''}</td>`;
                                table_manual += `<td>${rek.no_spp ?? ''}</td>`;
                                table_manual += `<td>${formatTanggal(rek.tgl_spp)}</td>`;
                                table_manual += `<td align="right">${formatRupiah(rek.jumlah)}</td>`;
                                table_manual += `<td align="center">`;

                                if (rek.status_spp_1 == 0) {
                                    table_manual += `<label class="badge badge-secondary">New</label>`;
                                } else if (rek.status_spp_1 == 1) {
                                    table_manual += `<label class="badge badge-success">Approved</label>`;
                                } else if (rek.status_spp_1 == 2) {
                                    table_manual += `<label class="badge badge-danger">Denied</label>`;
                                } else if (rek.status_spp_1 == 3) {
                                    table_manual += `<label class="badge badge-warning">Pending</label>`;
                                }

                                table_manual += `</td>`;
                                table_manual += `<td align="center"><a href="/approval_spp_manual/view_manual/${rek.no_urut}" class="btn btn-primary btn-sm">View</a></td>`;
                                            
                            table_manual += `</tr>`;

                        });
                        $("#table_manual").html(table_manual);
                    }
                });
            }else{
                
            }
        });
    </script>


@endsection