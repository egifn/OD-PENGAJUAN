@section('js')


<script type="text/javascript">
    
    function goBack() {
        window.history.back();
    }

    $(function(){
        $('#zona_eksternal_in').change(function(){
            var eksternal_in = $(this).val();
            if(eksternal_in){
                $.ajax({
                    type:"GET",
                    url:"/ajax_zona_eksternal_in?eksternal_in="+eksternal_in,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#sub_zona_eksternal_in").empty();
                            $("#sub_zona_eksternal_in").append('<option>Pilih</option>');
                            $.each(res,function(nama,kode){
                                $("#sub_zona_eksternal_in").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#sub_zona_eksternal_in").empty();
                        }
                    }
                });
            }else{
                $("#sub_zona_eksternal_in").empty();
            }
        });
    });

</script>


@stop

@extends('layouts.admin')

@section('title')
    <title>Mutasi Eksternal</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Mutasi</li>
        <li class="breadcrumb-item">Eksternal</li>
        <li class="breadcrumb-item active">Mutasi Eksternal Masuk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('mutasi_eksternal_in_leader.store') }}" method="post" onkeypress="return event.keyCode != 13" onsubmit="return validasi_input(this)" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Mutasi Eksternal</h4>
                            </div>
                            <div class="card-body">
                                
                                <div id="form-input-primary">
                                    <div id="form-input-primary" class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                BKB Mutasi
                                                <input type="text" name="bkb_mutasi" id="bkb_mutasi" class="form-control" value="{{ $data_head->kode_mutasi_eks }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_primary" id="no_mobil_primary" class="form-control" value="{{ $data_head->no_mobil }}" readonly>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Zona
                                                @if($data_head->status  == '0')
                                                <select name="zona_eksternal_in" id="zona_eksternal_in" class="form-control">
                                                    <option value="">Pilih</option>
                                                     @foreach ($area as $row)
                                                        <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                    @endforeach 
                                                </select>
                                                @else
                                                <input type="text" name="zona_eksternal_in" id="zona_eksternal_in" class="form-control" value="{{ $data_head->nama_area }}" readonly> 
                                                @endif
                                            </div>
        
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Dari Depo (Asal)
                                                <input type="text" name="depo_asal" id="depo_asal" class="form-control" value="{{ $data_head->nama_depo }}" readonly>
                                            </div>
                                            
                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_primary" id="nama_sopir_primary" class="form-control" value="{{ $data_head->nama_driver }}" readonly>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Sub Zona
                                                @if($data_head->status  == '0')
                                                <select name="sub_zona_eksternal_in" id="sub_zona_eksternal_in" class="form-control">
                                                    <option value="">Pilih</option>
                                                    
                                                </select>
                                                @else
                                                <input type="text" name="sub_zona_eksternal_in" id="zona_eksternal_in" class="form-control" value="{{ $data_head->nama_sub_area }}" readonly> 
                                                @endif
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                               Keterangan
                                                <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $data_head->keterangan }}" readonly> 
                                            </div>

                                            <div class="col-md-1 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                @if($data_head->status  == '0')
                                                <select name="id_checker_primary" class="form-control">
                                                    <option value="">Pilih</option>
                                                    @foreach ($checker_layak as $row)
                                                        <option value="{{ $row->id_checker }}" {{ old('id_checker') == $row->id_checker ? 'selected':'' }}>{{ $row->nama_checker }}</option>
                                                    @endforeach 
                                                </select>
                                                @else
                                                <input type="text" name="zona_eksternal_in" id="zona_eksternal_in" class="form-control" value="{{ $data_head->nama_checker }}" readonly> 
                                                @endif
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            

                                            
                                        </div>
                                        
                                    </div>
                                
                                </div>

                                <div class="row">
                                            
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <div style="border:1px white;width:100%;height:130px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                            <thead>
                                                                <tr>
                                                                    <th hidden>#</th>
                                                                    <th>Product Id</th>
                                                                    <th>Product Name</th>
                                                                    <th>Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse ($data_detail as $val)
                                                                <tr>
                                                                    <td hidden></td>
                                                                    <td>{{ $val->kode_produk }}</td>
                                                                    <td>{{ $val->nama_produk }}</td>
                                                                    <td>{{ $val->qty }}</td>
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
                                                    @if($data_head->status  == '0')
                                                        <button type="submit" class="btn btn-success btn-sm">S e t u j u.</button>

                                                        <a href="{{ route('mutasi_eksternal_in_leader/denied', $data_head->kode_mutasi_eks) }}" class="btn btn-danger btn-sm">Tidak Setuju</a>
                                                    @else
                                                        <button class="btn btn-success btn-sm" disabled>S e t u j u</button>
                                                        <button class="btn btn-danger btn-sm" disabled>Tidak Setuju</button>
                                                    @endif
                                                        


                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                        <button type="button" class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                    </div> 
                                                </div>
                                            </div>
                                             
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
                <h5 class="modal-title" id="exampleModalLabel">Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" >
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

<div class="modal fade bd-example-modal-lg" id="myModal_bkb" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">BKB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" onkeypress="return event.keyCode != 13">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_bkb" id="search_bkb" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_bkb" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No BKB</th>
                                <th>No Pol</th>
                                <th>Kode Sopir</th>
                                <th>Nama Sopir</th>

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




