@section('js')


<script type="text/javascript">

    function goBack() {
        window.history.back();
    }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("mutasi_eksternal_out_checker.store") }}',
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
    <title>Mutasi Eksternal</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Mutasi</li>
        <li class="breadcrumb-item">Eksternal</li>
        <li class="breadcrumb-item active">Mutasi Eksternal (Out)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('mutasi_eksternal_out_checker.store') }}" method="post" onkeypress="return event.keyCode != 13" onsubmit="return validasi_input(this)" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Mutasi Eksternal</h4>
                            </div>
                            <div class="card-body">

                                    <div id="form-input-primary" class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                DocId
                                                <input type="text" name="surat_jalan" id="surat_jalan" class="form-control" value="{{ $data_head->kode_mutasi_eks }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Dari Depo (Asal)
                                                <input type="text" name="depo_asal" id="depo_asal" class="form-control" value="{{ $data_head->nama_depo}}" readonly>
                                            </div> 
                                            
                                            <div class="col-md-2 mb-2">

                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Perusahaan Tujuan
                                                <!--<input type="text" name="pabrik" id="pabrik" class="form-control" value=""> -->
                                                <input type="text" name="perusahaan_tujuan" id="perusahaan_tujuan" class="form-control" value="{{ $data_head->perusahaan_tujuan }}" readonly>
                                            </div>
        
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_primary" id="no_mobil_primary" class="form-control" value="{{ $data_head->no_mobil }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Zona
                                                <input type="text" name="zona" id="zona" class="form-control" value="{{ $data_head->nama_area_asal }}" readonly>
                                                <input type="text" name="kd_zona" id="kd_zona" class="form-control" value="{{ $data_head->kode_area_asal }}" readonly hidden>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Depo Tujuan
                                                <!--<input type="text" name="pabrik" id="pabrik" class="form-control" value=""> -->
                                                <input type="text" name="depo_tujuan" id="depo_tujuan" class="form-control" value="{{ $data_head->depo_tujuan }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_primary" id="nama_sopir_primary" class="form-control" value="{{ $data_head->nama_driver }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Sub Zona
                                                <input type="text" name="sub_zona" id="sub_zona" class="form-control" value="{{ $data_head->nama_sub_area_asal }}" readonly>
                                                <input type="text" name="kode_sub_zona" id="kode_sub_zona" class="form-control" value="{{ $data_head->kode_sub_area_asal }}" readonly hidden>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Keterangan
                                                <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $data_head->keterangan }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <input type="text" name="nama_checker" id="nama_checker" class="form-control" value="{{ $data_head->nama_checker }}" readonly>
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
                                                                    <th hidden>#</th>
                                                                    <th>Product Id</th>
                                                                    <th>Product Name</th>
                                                                    <th>Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $no = 1; @endphp
                                                            @forelse ($data_detail as $val)
                                                                <tr>
                                                                    <td hidden>{{ $no++ }}</td>
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
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" hidden>Choose Product</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')" hidden>Delete Product</button>
                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                        @if($data_head->status_bm  == '0')
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




