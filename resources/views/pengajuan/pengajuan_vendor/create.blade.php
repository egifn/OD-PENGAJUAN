@section('js')
<script type="text/javascript">
    
</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Pengajuan Vendor</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item">Pengajuan Vendor</li>
        <li class="breadcrumb-item active">Buat Pengajuan Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan_vendor.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pengajuan Vendor</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Nama Vendor
                                        <input type="text" name="nama_vendor" id="nama_vendor" class="form-control" value="" required>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Alamat
                                        <input type="text" name="alamat" id="alamat" class="form-control" value="" required>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Telepon
                                        <input type="text" name="telepon" id="telepon" class="form-control" value="" required>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Kategori Vendor
                                        <input type="text" name="kategori" id="kategori" class="form-control" value="" required>
                                    </div>
                                </div>
                                <div class="row" hidden>   
                                                                        
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-2" align="right">
                                        <br>
                                        <button class="btn btn-primary">Simpan Pengajuan</button>
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

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_category" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Pengeluaran</th>
                                <th>Sifat</th>
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




