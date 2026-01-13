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
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item active">View Approval (Cost)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Approval (Cost)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Request ID : <strong>{{ $data->kode_pengajuan_b }}</strong>
                                    </div>
                                    
                                </div>
                               
                               <div class="table-responsive">
                                    
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>Approve Ka. Keuangan</th>
                                                    <th>Approve Ka. Ops Depo</th>
                                                    <th>Approve Pic. Biaya HO</th>
                                                    <th>Approve Ka. Biaya HO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data_approval as $row)
                                                <tr>
                                                    @if($row->status_biaya == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->biaya }} <br>
                                                            Status :&nbsp;
                                                            @if($row->status_biaya == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ket_biaya }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_biaya == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ket_biaya }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_biaya == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ket_biaya }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_biaya)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->status_atasan == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->ops }} <br>
                                                            Status :&nbsp;
                                                            @if($row->status_atasan == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ket_atasan }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_atasan == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ket_atasan }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_atasan == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ket_atasan }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_atasan)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->status_detail_acc == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->pic_akunting }} <br>
                                                            Status :&nbsp;
                                                            @if($row->status_detail_acc == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ket_pic }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_detail_acc == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ket_pic }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_detail_acc == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ket_pic }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_detail_acc)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->status_biaya_pusat == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->akunting }} <br>
                                                            Status :&nbsp;
                                                            @if($row->status_biaya_pusat == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ket_biaya_pusat }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_biaya_pusat == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ket_biaya_pusat }}</label> &nbsp;&nbsp;
                                                            @elseif($row->status_biaya_pusat == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ket_biaya_pusat }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            <br>
                                                            Tanggal : {{ date('d-M-Y', strtotime($row->tgl_approval_biaya_pusat)) }}
                                                        </td>
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


