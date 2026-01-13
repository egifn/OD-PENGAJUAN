@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        fetch_data_category();
        function fetch_data_category(query = '')
        {
            $.ajax({
                url:'{{ route("import_pencapaian/action.actionSuratProgram") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_data_category(query);
        });
    });

    $(document).on('click', '.pilih', function(e){
        document.getElementById('no_surat').value = $(this).attr('data-no_surat')
        //document.getElementById('no_surat_tiv').value = $(this).attr('')
        document.getElementById('kode_perusahaan').value = $(this).attr('data-kode_perusahaan')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('id_program').value = $(this).attr('data-id_program')
        document.getElementById('nama_program').value = $(this).attr('data-nama_program')
        // alert(document.getElementById('id_pengeluaran').value);
        
        $('#myModal').modal('hide');
    });

    $("#batal").click(function(){
        $('#no_surat').val('');
        $('#no_surat_tiv').val('');
        $('#kode_perusahaan').val('');
        $('#kategori').val('');
        $('#id_program').val('');
        $('#nama_program').val('');
        $('#keterangan').val('');
        $('#file').val('');
        $('#file_upload_1').val('');
    });

    $("#button_hapus_import").click(function(){
        $('#file').val('');
    });

    $("#button_hapus_attch").click(function(){
        $('#file_upload_1').val('');
    });

</script>

@stop

@extends('layouts.admin')

@section('title')
    {{-- <title>Import Data DMS</title> --}}
    <title>Import Pencapaian</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Pencapaian Program</li>
        <li class="breadcrumb-item">Daftar Pencapaian</li>
        <li class="breadcrumb-item active">Import Pencapaian</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('import_pencapaian/import.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    {{-- Import Data DMS --}}
                                    Import Pencapaian
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        
                                        <button type="button" id="caridatas" name="caridatas" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Cari Surat</button>

                                        <button type="button" id="batal" name="batal" class="btn btn-warning btn-sm">Batal/Reset</button>
                                    </div>  
                                   
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <strong>No Surat Distributor</strong>
                                        <input type="text" class="form-control" name="no_surat" id="no_surat" value="" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <strong>No Surat TIV</strong>
                                        <input type="text" class="form-control" name="no_surat_tiv" id="no_surat_tiv" value="" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <strong>Perusahaan</strong>
                                        <input type="text" class="form-control" name="kode_perusahaan" id="kode_perusahaan" value="" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <strong>Kategori</strong>
                                        <input type="text" class="form-control" name="kategori" id="kategori" value="" readonly>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-2">
                                        <strong>Id Program</strong>
                                        <input type="text" class="form-control" name="id_program" id="id_program" value="" readonly>
                                    </div> 
                                    
                                    <div class="col-md-10">
                                        <strong>Nama Program</strong>
                                        <input type="text" class="form-control" name="nama_program" id="nama_program" value="" readonly>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Keterangan</strong>
                                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="" required>
                                    </div>                                      
                                </div>
                                <br>
                                <div class="row">   
                                    <div class="col-md-12 mb-2">
                                        <strong>Import File Data Pencapaian (file *.xlsx, *.xls)</strong>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="file" id="file" required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-danger" id="button_hapus_import" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                            </span>
                                        </div>
                                    </div>  
                                </div>
                                <br>
                                <div class="row" >
                                    <div class="col-md-12 mb-2">
                                        <strong>Attach file (Upload dokumen pendukung)</strong>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="file_upload[]" id="file_upload_1" multiple>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-danger" id="button_hapus_attch" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-success btn-sm float-right">P r o s e s</button>
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
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Surat Program</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No Surat Distributor</th>
                                <th>No Surat TIV</th>
                                <th>Perusahaan</th>
                                <th>Id Program</th>
                                <th>Nama Program</th>
                                <th>Kategori</th>
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