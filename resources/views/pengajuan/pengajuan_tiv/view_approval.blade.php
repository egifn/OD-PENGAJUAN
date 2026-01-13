@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>View Approval</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Tanggungan TIV</li>
        <li class="breadcrumb-item active">View Approval (Pengajuan TIV)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Approval (Pengajuan TIV)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Request ID : <strong>{{ $data->kode_pengajuan_b }}</strong>
                                    </div>
                                    
                                </div>
                               
                               <div class="table-responsive">
                                    
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>Approve SSD</th>
                                                    <th hidden>Approve SND</th>
                                                    <th>Approve SOM</th>
                                                    <th>Approve Claim</th>
                                                    <th>Approve Piutang NG</th>
                                                    <th>Approve Piutang Depo</th>
                                                    <th>Approve Biaya</th>
                                                    <th>No SPP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data_approval as $row)
                                                <tr>
                                                    @if($row->st_ssd == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->nama_ssd }} <br>
                                                            Status :&nbsp;
                                                            @if($row->st_ssd == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ssd }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ssd == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ssd }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ssd == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ssd }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_ssd)) }}
                                                        </td>
                                                    @endif
                                                    
                                                    <!-- @if($row->st_snd == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->nama_snd }} <br>
                                                            Status :&nbsp;
                                                            @if($row->st_snd == '1') 
                                                                <label class="badge badge-success">{{ $row->status_snd }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_snd == '2')
                                                                <label class="badge badge-danger">{{ $row->status_snd }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_snd == '3')
                                                                <label class="badge badge-warning">{{ $row->status_snd }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_atasan)) }}
                                                        </td>
                                                    @endif -->

                                                    @if($row->st_som == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->nama_som }} <br>
                                                            Status :&nbsp;
                                                            @if($row->st_som == '1') 
                                                                <label class="badge badge-success">{{ $row->status_som }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_som == '2')
                                                                <label class="badge badge-danger">{{ $row->status_som }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_som == '3')
                                                                <label class="badge badge-warning">{{ $row->status_som }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_som)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->st_claim == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->nama_claim }} <br>
                                                            Status :&nbsp;
                                                            @if($row->st_claim == '1') 
                                                                <label class="badge badge-success">{{ $row->status_claim }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_claim == '2')
                                                                <label class="badge badge-danger">{{ $row->status_claim }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_claim == '3')
                                                                <label class="badge badge-warning">{{ $row->status_claim }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_claim)) }}
                                                        </td>
                                                    @endif
                                                    
                                                    @if($row->st_ng == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->nama_ng }} <br>
                                                            Status :&nbsp;
                                                            @if($row->st_ng == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ng }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ng == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ng }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ng == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ng }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_ng)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->st_piutang == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->nama_piutang }} <br>
                                                            Status :&nbsp;
                                                            @if($row->st_piutang == '1') 
                                                                <label class="badge badge-success">{{ $row->status_piutang }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_piutang == '2')
                                                                <label class="badge badge-danger">{{ $row->status_piutang }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_piutang == '3')
                                                                <label class="badge badge-warning">{{ $row->status_piutang }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_piutang)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->st_biaya == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->nama_biaya }} <br>
                                                            Status :&nbsp;
                                                            @if($row->st_biaya == '1') 
                                                                <label class="badge badge-success">{{ $row->status_biaya }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_biaya == '2')
                                                                <label class="badge badge-danger">{{ $row->status_biaya }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_biaya == '3')
                                                                <label class="badge badge-warning">{{ $row->status_biaya }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_ng)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->status_buat_spp == '0')
                                                        <td></td>
                                                    @else
                                                        <td><br><b><a href="{{ route('pengajuan_tiv/pdf_spp.pdf_spp', $row->no_urut) }}" target="_blank">{{ $row->no_spp }}</a></b></td>
                                                    @endif
                                                    
                                                </tr>
                                                @empty
                                                <tr>
                                                
                                                </tr>
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
</main>

@endsection

@section('script')



@endsection


