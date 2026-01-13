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
        <li class="breadcrumb-item active">Status Kirim</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Status Kirim</h4>
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
                                                    <th>No</th>
                                                    <th>Perusahaan</th>
                                                    <th>Depo</th>
                                                    <th>Status Kirim</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($data_view_terima as $row)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $row->nama_perusahaan }}</td>
                                                    <td>{{ $row->nama_depo }}</td>
                                                    <td align="center">
                                                        @if($row->status_terima_asm == '0')
                                                            ASM: <label class="badge badge-warning">Belum Terbaca</label> &nbsp;&nbsp;&nbsp;
                                                        @else
                                                            ASM: <label class="badge badge-success">Sudah diterima</label> &nbsp;&nbsp;&nbsp;
                                                        @endif

                                                        @if($row->status_terima_kpj == '0')
                                                            KPJ: <label class="badge badge-warning">Belum Terbaca</label> &nbsp;&nbsp;&nbsp;
                                                        @else
                                                            KPJ: <label class="badge badge-success">Sudah diterima</label> &nbsp;&nbsp;&nbsp;
                                                        @endif
                                                    </td>
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


