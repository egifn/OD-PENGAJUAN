@section('js')
<script type="text/javascript">
    
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Edit Asset</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Asset</li>
        <li class="breadcrumb-item active">Edit Asset</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Edit Asset</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" class="form-control" value="" required readonly hidden>
                                        <input type="text" name="perusahaan" class="form-control" value="" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Depo
                                        <input type="text" name="kode_depo" class="form-control" value="" required readonly hidden>
                                        <input type="text" name="depo" class="form-control" value="" required readonly>
                                    </div>

                                </div>
                                <hr>
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Nama Asset/Item
                                        <div class="input-group">
                                            <input id="kode_asset" type="hidden" name="kode_asset" value="" required >
                                            <input id="nama_asset" type="text" name="nama_asset" class="form-control" readonly required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalAsset"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Merk
                                        <input type="text" name="merk" id="merk" class="form-control">
                                    </div>
                                    <div class="col-md-7 mb-2">
                                        Speksifikasi/Model
                                        <input type="text" name="spek" id="spek" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="field_wrapper">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            Area Penempatan
                                            <div class="input-group">
                                                <input id="kode_penempatan" type="hidden" name="kode_penempatan" value="" required >
                                                <input id="nama_penempatan" type="text" name="nama_penempatan" class="form-control" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalPenempatan"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            User Pemegang
                                            <div class="input-group">
                                                <input id="kode_pemegang" type="hidden" name="kode_pemegang" value="" required >
                                                <input id="nama_pemegang" type="text" name="nama_pemegang" class="form-control" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalPemegang"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Kondisi Asset (Aktual)
                                            <select name="kondisi" id="kondisi" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                                                <option value="Rusak (Perlu diganti)">Rusak (Perlu diganti)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            Tgl Pengadaan
                                            <input type="date" name="tgl_pengadaan" id="tgl_pengadaan" class="form-control" value="">
                                        </div>

                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        No Dok Akuisisi
                                        <input type="text" name="no_dok" id="no_dok" class="form-control" value="">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jml Asset
                                        <input type="number" name="jml_asset" id="jml_asset" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        N. Baik
                                        <input type="number" name="baik" id="baik" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        N. Perlu diganti
                                        <input type="number" name="perlu_ganti" id="perlu_ganti" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        N. Perlu perbaikan
                                        <input type="number" name="perlu_perbaikan" id="perlu_perbaikan" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        N. Dalam perbaikan
                                        <input type="number" name="dalam_perbaikan" id="dalam_perbaikan" class="form-control" value="0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        Keterangan
                                        <input type="text" name="keterangan" id="keterangan" class="form-control" value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-5 mb-2" hidden>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        
                                    </div>

                                    <div class="col-md-8 mb-2" align="right">
                                        <br>
                                        <button class="btn btn-success">Simpan Asset</button>
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

<div class="modal fade bd-example-modal-lg" id="myModalAsset" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_asset" id="search_asset" class="form-control" placeholder="Cari Asset . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_asset" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Asset</th>
                                <th>Nama Asset</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalPemegang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar User Pemegang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_pemegang" id="search_pemegang" class="form-control" placeholder="Cari User/Pemegang . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_pemegang" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Pemegang</th>
                                <th>Nama Pemegang</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalPenempatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Penempatan/Lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_penempatan" id="search_penempatan" class="form-control" placeholder="Cari Penempatan/Lokasi . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_penempatan" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Penempatan</th>
                                <th>Penempatan/Lokasi</th>
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




