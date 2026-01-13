@section('js')


<script type="text/javascript">

     function goBack() {
        window.history.back();
    }

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
            <form action="{{ route('mutasi.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
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
                                                kode_mutasi 
                                                <input type="text" name="kode_mutasi" id="kode_mutasi" class="form-control" value="{{ $head->kode_mutasi }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Dari Zona
                                                <input type="text" name="dari_zona" id="dari_zona" class="form-control" value="{{ $head->nama_area_asal }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Ke Zona 
                                                <input type="text" name="ke_zona" id="ke_zona" class="form-control" value="{{ $head->nama_area_tujuan }}" readonly>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                        
                                            <div class="col-md-3 mb-2">
                                                Dari Sub Zona
                                                <input type="text" name="dari_sub_zona" id="dari_sub_zona" class="form-control" value="{{ $head->nama_sub_area_asal }}" readonly>

                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Ke Sub Zona
                                                <input type="text" name="ke_sub_zona" id="ke_sub_zona" class="form-control" value="{{ $head->nama_sub_area_tujuan }}" readonly>
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
                                                                    <th hidden>#</th>
                                                                    <th>Product Id</th>
                                                                    <th>Product Name</th>
                                                                    <th>Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse ($detail as $val)
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
                                                    @if($head->status  == '0')
                                                        <a href="{{ route('mutasi_internal_leader/approved', $head->kode_mutasi) }}" class="btn btn-success btn-sm">S e t u j u</a>
                                                        <a href="{{ route('mutasi_internal_leader/denied', $head->kode_mutasi) }}" class="btn btn-danger btn-sm">Tidak Setuju</a>
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




