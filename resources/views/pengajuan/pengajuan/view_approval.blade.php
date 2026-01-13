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
        <li class="breadcrumb-item active">View Approval</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Approval</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Kode Pengajuan :
                                        <strong>{{ $data->kode_pengajuan }}</strong> <br>
										Tgl Pengajuan :
										<strong>{{ date('d-M-Y', strtotime($data->tgl_pengajuan)) }}</strong>		
                                    </div>
                                    
                                </div>
                               
                               <div class="table-responsive">
                                    
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
													<th>Approve Atasan</th>
                                                    <th>Approve IT</th>
                                                    <th>Approve Ops</th>
                                                    <th>Approve GA</th>
                                                    <th>Approve Purchasing</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data_approval as $row)
                                                <tr>
                                                    @if($row->st_atasan == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->atasan }} &nbsp;&nbsp;
                                                            @if($row->st_atasan == '1') 
                                                                <label class="badge badge-success">{{ $row->status_atasan }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_atasan == '2')
                                                                <label class="badge badge-danger">{{ $row->status_atasan }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_atasan == '3')
                                                                <label class="badge badge-warning">{{ $row->status_atasan }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            tgl {{ date('d-M-Y', strtotime($row->tgl_approval_atasan)) }}
                                                        </td>
                                                    @endif
                                                    
                                                    @if($row->it == '')
                                                        <td><label class="badge badge-secondary"></label></td>
                                                    @else
                                                        <td>{{ $row->it }} &nbsp;&nbsp;
                                                            @if($row->st_it == '1') 
                                                                <label class="badge badge-success">{{ $row->status_it }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_it == '2')
                                                                <label class="badge badge-danger">{{ $row->status_it }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_it == '3')
                                                                <label class="badge badge-warning">{{ $row->status_it }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            tgl {{ date('d-M-Y', strtotime($row->tgl_approval_it)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->st_ops == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->ops }} &nbsp;&nbsp;
                                                            @if($row->st_ops == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ops }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ops == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ops }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ops == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ops }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            tgl {{ date('d-M-Y', strtotime($row->tgl_approval_ops)) }}
                                                        </td>
                                                    @endif

                                                    @if($row->st_ga == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->ga }} &nbsp;&nbsp;
                                                            @if($row->st_ga == '1') 
                                                                <label class="badge badge-success">{{ $row->status_ga }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ga == '2')
                                                                <label class="badge badge-danger">{{ $row->status_ga }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_ga == '3')
                                                                <label class="badge badge-warning">{{ $row->status_ga }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            tgl {{ date('d-M-Y', strtotime($row->tgl_approval_ga)) }}
                                                        </td>
                                                    @endif
                                                    
                                                    @if($row->st_pc == '0')
                                                        <td></td>
                                                    @else
                                                        <td>{{ $row->pc }} &nbsp;&nbsp;
                                                            @if($row->st_pc == '1') 
                                                                <label class="badge badge-success">{{ $row->status_pc }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_pc == '2')
                                                                <label class="badge badge-danger">{{ $row->status_pc }}</label> &nbsp;&nbsp;
                                                            @elseif($row->st_pc == '3')
                                                                <label class="badge badge-warning">{{ $row->status_pc }}</label> &nbsp;&nbsp;
                                                            @endif
                                                            tgl {{ date('d-M-Y', strtotime($row->tgl_approval_pc)) }}
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


