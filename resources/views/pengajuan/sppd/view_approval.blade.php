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
        <li class="breadcrumb-item">SPPD</li>
        <li class="breadcrumb-item active">View Approval (SPPD)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Approval (SPPD)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Request ID : <strong>{{ $data->kode_pengajuan_sppd }}</strong>
                                    </div>
                                    
                                </div>
                               
                               <div class="table-responsive">
                                    
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>Approve 1</th>
                                                    <th>Approve 2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data_approval as $row)
                                                <tr>
                                                    <td>{{ $row->biaya }}</td>
                                                    <td>{{ $row->hrd }}</td>
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


