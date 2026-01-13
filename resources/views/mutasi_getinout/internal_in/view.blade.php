@section('js')


<script type="text/javascript">

     function goBack() {
        window.history.back();
    }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("mutasi_internal_in.store") }}',
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
    <title>View Mutasi</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Mutasi</li>
        <li class="breadcrumb-item active">View Mutasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('mutasi_internal_in.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Mutasi [{{ $head->kode_mutasi }}]</h4>
                            </div>
                            <div class="card-body">
                                <div id="form-input-primary">
                                    <div id="form-input-primary" class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2" hidden>
                                                kode
                                                <input type="text" name="doc_id" id="doc_id" class="form-control" value="{{ $head->kode_mutasi }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Dari Zona
                                                <input type="text" name="dari_zona" id="dari_zona" class="form-control" value="{{ $head->nama_area_asal }}" readonly>
                                                <input type="text" name="kd_dari_zona" id="kd_dari_zona" class="form-control" value="{{ $head->kode_area_asal }}" readonly hidden>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Ke Zona 
                                                <input type="text" name="ke_zona" id="ke_zona" class="form-control" value="{{ $head->nama_area_tujuan }}" readonly>
                                                <input type="text" name="kd_ke_zona" id="kd_ke_zona" class="form-control" value="{{ $head->kode_area_tujuan }}" readonly hidden>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                        
                                            <div class="col-md-3 mb-2">
                                                Dari Sub Zona
                                                <input type="text" name="dari_sub_zona" id="dari_sub_zona" class="form-control" value="{{ $head->nama_sub_area_asal }}" readonly>
                                                <input type="text" name="kd_dari_sub_zona" id="kd_dari_sub_zona" class="form-control" value="{{ $head->kode_sub_area_asal }}" readonly hidden>

                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Ke Sub Zona
                                                <input type="text" name="ke_sub_zona" id="ke_sub_zona" class="form-control" value="{{ $head->nama_sub_area_tujuan }}" readonly>
                                                <input type="text" name="kd_ke_sub_zona" id="kd_ke_sub_zona" class="form-control" value="{{ $head->kode_sub_area_tujuan }}" readonly hidden>
                                            </div>

                                        </div>

                                        <div class="row" hidden>
                                            
                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <select name="id_checker_primary" class="form-control">
                                                    <option value="">Pilih</option>
                                                    
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <select name="id_checker_primary_bs" class="form-control">
                                                    <option value="">Pilih</option>
                                                   
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                            <form id="savedatas">
                                                <div class="card-body">
                                                <div class="table-responsive">
                                                    <div style="border:1px white;width:100%;height:130px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Product Id</th>
                                                                    <th>Product Name</th>
                                                                    <th>Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $no = 1; @endphp
                                                            @forelse ($detail as $val)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="kode_produk[]" id="kode_produk" style="font-size: 13px;" value="{{ $val->kode_produk }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="font-size: 13px;" value="{{ $val->nama_produk }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty) }}">
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" hidden>Pilih Produk</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')" hidden>Hapus Produk</button>
                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                    @if($head->status == '1')
                                                        <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                    @else
                                                        <button class="btn btn-primary btn-sm float-right" disabled>S i m p a n</button>
                                                    @endif
                                                    </div> 
                                                </div>
                                                </div>
                                            </form>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_product" id="search_product" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Product Id</th>
                                <th>Product Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')



@endsection




