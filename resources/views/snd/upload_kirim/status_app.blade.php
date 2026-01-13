@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Status Kirim</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Surat Program</li>
        <li class="breadcrumb-item active">View Approve</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Approve</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        No Surat : <strong>{{ $rekap_app_surat_header->no_surat }}</strong>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        ID Program : <strong>{{ $rekap_app_surat_header->id_program }}</strong>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        Nama Program : <strong>{{ $rekap_app_surat_header->nama_program }}</strong>
                                    </div>
                                </div>
                               
                               <div class="table-responsive">
                                    
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>Approve SSD</th>
                                                    <th>Approve Manager SND</th>
                                                    <th>Approve SOM</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data_view_status as $row)
                                                    <tr>
                                                        <th>
                                                            @if($row->status_approval_ssd == '0')
                                                                Status: <label class="badge badge-warning">Menunggu</label> 
                                                            @elseif($row->status_approval_ssd == '1')
                                                                Status: <label class="badge badge-success">Approved</label> <br>
                                                                Disetujui oleh: {{ $row->nama_ssd }} <br>
                                                                Pada tanggal: {{ date('d-M-Y', strtotime($row->tgl_approval_ssd)) }} <br>
                                                                Keterangan: {{ $row->keterangan_ssd }}
                                                            @elseif($row->status_approval_ssd == '2')
                                                                Status: <label class="badge badge-danger">Tolak</label> <br>
                                                                Ditolak oleh: {{ $row->nama_ssd }} <br>
                                                                Pada tanggal: {{ date('d-M-Y', strtotime($row->tgl_approval_ssd)) }} <br>
                                                                Keterangan: {{ $row->keterangan_ssd }} 
                                                            @endif
                                                        </th>
                                                    
                                                        <th>
                                                            @if($row->status_approval_manager == '0')
                                                                Status: <label class="badge badge-warning">Menunggu</label> 
                                                            @elseif($row->status_approval_manager == '1')
                                                                Status: <label class="badge badge-success">Approved</label> <br>
                                                                Disetujui oleh: {{ $row->nama_manager }} <br>
                                                                Pada tanggal: {{ date('d-M-Y', strtotime($row->tgl_approval_manager)) }} <br>
                                                                Keterangan: {{ $row->keterangan_manager }}
                                                            @elseif($row->status_approval_manager == '2')
                                                                Status: <label class="badge badge-danger">Tolak</label> <br>
                                                                Ditolak oleh: {{ $row->nama_manager }} <br>
                                                                Pada tanggal: {{ date('d-M-Y', strtotime($row->tgl_approval_manager)) }} <br>
                                                                Keterangan: {{ $row->keterangan_manager }}
                                                            @endif
                                                        </th>
                                                        
                                                        <th>
                                                            @if($row->status_approval_som == '0')
                                                                Status: <label class="badge badge-warning">Menunggu</label> 
                                                            @elseif($row->status_approval_som == '1')
                                                                Status: <label class="badge badge-success">Approved</label> <br>
                                                                Disetujui oleh: {{ $row->nama_som }} <br>
                                                                Pada tanggal: {{ date('d-M-Y', strtotime($row->tgl_approval_som)) }} <br>
                                                                Keterangan: {{ $row->keterangan_som }}
                                                            @elseif($row->status_approval_som == '2')
                                                                Status: <label class="badge badge-danger">Tolak</label> <br>
                                                                Ditolak oleh: {{ $row->nama_som }} <br>
                                                                Pada tanggal: {{ date('d-M-Y', strtotime($row->tgl_approval_som)) }} <br>
                                                                Keterangan: {{ $row->keterangan_som }}
                                                            @endif
                                                        </th>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                    
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                
                                        <div class="col-md-12 mb-2">  
                                            <button type="button" id="kembali" name="kembali" class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
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

@section('script')



@endsection


