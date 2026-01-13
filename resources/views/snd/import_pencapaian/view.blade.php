@extends('layouts.admin')

@section('title')
    <!-- <title>Import Data DMS</title> -->
    <title>View Detail Pencapaian</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Pencapaian Program</li>
        <li class="breadcrumb-item">Daftar Pencapaian</li>
        <li class="breadcrumb-item active">View Detail Pencapaian</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                View Detail Pencapaian
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
                                
                            </form>

                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    Tgl Upload dan Kirim
                                    <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime($data_header->tgl_import)) }}" required readonly>
                                </div>

                                <div class="col-md-4 mb-2">
                                    No Surat
                                    <input type="text" name="no_surat" id="no_surat" class="form-control" value="{{ $data_header->no_surat }}" required readonly>
                                </div>

                                <div class="col-md-4 mb-2">
                                    Kategori
                                    <input type="text" name="kategori" id="kategori" class="form-control" value="{{ $data_header->kategori }}" required readonly>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Tgl Import</th>
                                                <th hidden >No Surat</th>
                                                <th hidden>kode depo</th>
                                                <th>Depo</th>
                                                <th hidden>kode segmen</th>
                                                <th>Segmen</th>
                                                <th>Cluster</th>
                                                <th>Kode Outlet</th>
                                                <th>Outlet</th>
                                                @if($data_header->kategori == 'Program TIV')
                                                    <th>Reward TIV</th>
                                                @elseif($data_header->kategori == 'Program Distributor')
                                                    <th>Reward Distributor</th>
                                                @elseif($data_header->kategori == 'Sharing TUA TIV')
                                                    <th>Reward Distributor</th>
                                                    <th>Reward TIV</th>
                                                @endif
                                                <th>Total Reward</th>
                                                <th hidden>Id User Input</th>
                                                <th hidden>Nama User Input</th>
                                                <th hidden>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse ($data as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td hidden>{{ $val->tgl_import }}</td>
                                                <td hidden>{{ $val->no_surat }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kode_segmen }}</td>
                                                <td>{{ $val->nama_segmen }}</td>
                                                <td>{{ $val->cluster }}</td>
                                                <td>{{ $val->kode_outlet }}</td>
                                                <td>{{ $val->nama_outlet }}</td>
                                                @if($data_header->kategori == 'Program TIV')
                                                    <td align="right">{{ number_format($val->reward_tiv) }}</td>
                                                    <td align="right">{{ number_format($val->reward_tiv) }}</td>
                                                @elseif($data_header->kategori == 'Program Distributor')
                                                    <td align="right">{{ number_format($val->reward) }}</td>
                                                    <td align="right">{{ number_format($val->reward) }}</td>
                                                @elseif($data_header->kategori == 'Sharing TUA TIV')
                                                    <td align="right">{{ number_format($val->reward) }}</td>
                                                    <td align="right">{{ number_format($val->reward_tiv) }}</td>
                                                    <td align="right">{{ number_format($val->reward + $val->reward_tiv) }}</td>
                                                @endif
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                            </tr>
                                            <?php $no++ ?>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" align="center"><b>T o t a l</b></td>
                                                @if($data_header->kategori == 'Program TIV')
                                                    <td align="right"><b>{{ number_format($data_total->total_tiv) }}</b></td>
                                                    <td align="right"><b>{{ number_format($data_total->total_tiv) }}</b></td>
                                                @elseif($data_header->kategori == 'Program Distributor')
                                                    <td align="right"><b>{{ number_format($data_total->total_dist) }}</b></td>
                                                    <td align="right"><b>{{ number_format($data_total->total_dist) }}</b></td>
                                                @elseif($data_header->kategori == 'Sharing TUA TIV')
                                                    <td align="right"><b>{{ number_format($data_total->total_dist) }}</b></td>
                                                    <td align="right"><b>{{ number_format($data_total->total_tiv) }}</b></td>
                                                    <td align="right"><b>{{ number_format($data_total->total_dist + $data_total->total_tiv) }}</b></td>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
							
							<br>
                            <div class="row"> 
                                <div class="col-md-12 mb-2">
                                    <div class="input-group mb-3">
                                        
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($approval_upload as $row)
                                                <tr>
                                                    <td><i><b>Attachment_{{ $no }}</b></i></td>
                                                    <td>
                                                        <a href="{{url('images/'. $row->filename)}}">
                                                            {{ $row->filename}}
                                                        </a>
                                                        
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

