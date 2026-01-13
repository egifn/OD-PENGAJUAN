@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Kontrabon Detail</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Sparepart</li>
        <li class="breadcrumb-item">Kontrabon</li>
        <li class="breadcrumb-item active">View</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Kontrabon (View)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">Id : <b>{{ $kontra_head->no_kontrabon }}</b></label>
                                    </div>

                                    <div class="col-md-2 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label for="termin">Termin : <b>{{ $kontra_head->termin }}</b></label>   
                                    </div>
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="supplier">Vendor : <b>{{ $kontra_head->nama_vendor }}</b></label>
                                    </div>

                                    <div class="col-md-2 mb-2 float-right">

                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="due_date">Due Date : <b>{{ date('d-M-Y', strtotime($kontra_head->jatuh_tempo)) }}</b></label>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <label for="tgl">Date : <b>{{ date('d-M-Y', strtotime($kontra_head->tgl_kontrabon)) }}</b></label>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="total">Total : <b>Rp. {{ number_format($kontra_head->total) }}</b></label>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="description">Description : <b>{{ $kontra_head->keterangan }}</b></label>
                                    </div>
                                </div>

                                <br>

                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>No BTB</th>
                                                    <th>Invoice</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @forelse($kontra_detail as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->no_transaksi }}</td>
                                                    <td>{{ $val->no_faktur }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($val->tgl_faktur)) }}</td>
                                                    <td align="right">{{ number_format($val->total_faktur) }}</td>
                                                    <td align="right">{{ number_format($val->total_faktur) }}</td>
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
                                <div class="row"> 
                                    

                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
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


