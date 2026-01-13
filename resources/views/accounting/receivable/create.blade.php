@section('js')
<script type="text/javascript">
    
    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("receivable_store.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Tambah Pengajuan</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Accounting</li>
        <li class="breadcrumb-item active">Create Counter Bill</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('receivable_store.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Counter Bill</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Counter Bill ID
                                        <input type="text" name="no_kb" class="form-control" value="{{ $no_kb }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Termin
                                        <input type="text" name="termin" class="form-control" required value="">
                                        
                                    </div>

                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2 float-right">
                                        Supplier Name
                                        <div class="input-group">
                                            <input id="supplier" type="text" name="supplier" value="{{ $kontrabon->nama_vendor }}" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ $kontrabon->kode_vendor }}" required readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Due date
                                        <input id="jatuh_tempo" type="date" class="form-control" name="jatuh_tempo" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                     
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Date
                                        <input type="text" name="tgl_kb" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" >
                                        Total
                                        <input style="text-align: right;" type="text" name="total_head" class="form-control" value="{{ $kontrabon->total }}" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" >
                                        
                                    </div>
                                    <div class="col-md-6 mb-2" >
                                        Description
                                        <input type="text" name="description" class="form-control" value="" required>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <form id="savedatas">
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;font-size: 13px;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>No BTB</th>
                                                    <th>Invoice</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Sub Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($kontrabon_detail as $val)
                                                <tr>
                                                    <td hidden>
                                                        <input type="text" class="form-control" name="no_btb[]" id="no_btb_" style="font-size: 13px;" value="{{ $val->no_btb }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="no_faktur[]" id="no_faktur_" style="font-size: 13px;" value="{{ $val->no_faktur }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="tanggal[]" id="tanggal_" style="font-size: 13px;" value="{{ $val->tgl_faktur }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="total[]" id="total_" style="font-size: 13px;text-align: right;" value="{{ $val->total }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="sub_total[]" id="sub_total_" style="font-size: 13px;text-align: right;" value="{{ $val->total }}" readonly>
                                                    </td>
                                                    <td align="center">
                                                        <a href="{{ route('view_invoice.view', $val->no_faktur) }}" class="btn btn-primary btn-sm">View</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>    
                                
                              
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Create</button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
</main>


@endsection

<script text="text/javascript">
    function jumlah(aa){ 
      a=eval(document.getElementById("harga_"+aa).value);
      b=eval(document.getElementById("qty_"+aa).value);
      c=a*b;
      document.getElementById("total_"+aa).value=c;

     
      //document.getElementById("total_harga").value = 0;
    }
       
</script> 


