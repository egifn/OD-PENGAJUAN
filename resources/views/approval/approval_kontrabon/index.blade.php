@extends('layouts.admin')

@section('title')
    <title>Approve Kontrabon</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">App Kontrabon</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Approve Kontrabon
                            </h4>
                        </div>
                        
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
							
							<form action="{{ route('approval_kontrabon/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>
							
                            <div class="table-responsive">
                              
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>No Kontrabon</th>
                                                <th>Tanggal</th>
                                                <th hidden>Vendor ID</th>
                                                <th>Vendor</th>
                                                <th>Total</th>
                                                <th>Dibuat Oleh</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($counter_bill as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->no_kontrabon }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_kontrabon)) }}</td>
                                                <td hidden>{{ $val->kode_vendor }}</td>
                                                <td>{{ $val->nama_vendor }}</td>
                                                <td align="right">{{ number_format($val->total) }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                @if($val->status_kontra == '0')
                                                    <label class="badge badge-secondary">Baru</label>
                                                @elseif($val->status_kontra == '1')
                                                    <label class="badge badge-success">Approved</label>
                                                @endif
                                                </td>
                                                <td align="center">
                                                    <a href="{{ route('approval_kontrabon/view.view',$val->no_kontrabon) }}" class="btn btn-primary btn-sm">View</a>
                                                    <a href="#" class="btn btn-warning btn-sm" hidden>Print</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    $(function(){
        var url = document.location.toString();
        if (url.match('#')) {
            console.log(url.split('#')[1]);
            $('a[href="#'+url.split('#')[1]+'"]').parent().addClass('active');
            $('#'+url.split('#')[1]).addClass('active in')
        }
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
             window.location.hash = e.target.hash;
        });
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