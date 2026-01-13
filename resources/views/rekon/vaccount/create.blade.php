@extends('layouts.admin')

@section('title')
    <title>Tambah Virtual Account</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Rekonsiliasi</li>
        <li class="breadcrumb-item">Virtual Account</li>
        <li class="breadcrumb-item active">Tambah Virtual Account</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('virtualaccount.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-10">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Virtual Account</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="va">Virtual Account</label>
                                        <input type="text" name="va" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('va') }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="kode_perusahaan">Perusahaan</label>
                                    
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                            <option value="">Pilih</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger">{{ $errors->first('kode_perusahaan') }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="kode_depo">Depo</label>
                                    
                                        <select name="kode_depo" id="kode_depo" class="form-control">
                                            <option value="-">Pilih Depo</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2"">
                                        <label for="jenis">Jenis</label>
                                    
                                        <select name="jenis" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="Mineral">Mineral</option>
                                            <option value="Jasa">Jasa</option>
                                            
                                        </select>
                                        <p class="text-danger">{{ $errors->first('kode_bank') }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="norek">No.Rekening</label>
                                    
                                        <select name="norek" id="norek" class="form-control">
                                            <option value="">Pilih</option>
                                            
                                        </select>
                                        <p class="text-danger">{{ $errors->first('norek') }}</p>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2" hidden>
                                        <label for="user">kode_user</label>
                                        <input type="text" name="kode_user" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- ############################################################################################  -->
              
                </div>
            </form>
        </div>
    </div>
</main>
@endsection


@section('js')
<script>
        $(function(){
            $('#kode_perusahaan').change(function(){
                var perusahaandms_id = $(this).val();
                if(perusahaandms_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo_va?perusahaandms_id="+perusahaandms_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#kode_depo").empty();
                                $("#kode_depo").append('<option value="">Pilih Depo</option>');
                                $.each(res,function(nama,kode){
                                    $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#kode_depo").empty();
                            }
                        }
                    });
                }else{
                    $("#kode_depo").empty();
                }
            });
        });

        $(function(){
            $('#kode_perusahaan').change(function(){
                var perusahaanrek_id = $(this).val();
                if(perusahaanrek_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_rekening_bank?perusahaanrek_id="+perusahaanrek_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#norek").empty();
                                $("#norek").append('<option value="">Pilih Rekening</option>');
                                $.each(res,function(norek,norek){
                                    $("#norek").append('<option value="'+norek+'">'+norek+'</option>');
                                });
                            }else{
                                $("#norek").empty();
                            }
                        }
                    });
                }else{
                    $("#norek").empty();
                }
            });
        });

        $(function(){
            $('#kode_depo').change(function(){
                var deporek_id = $(this).val();
                if(deporek_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_rekening_bank_depo?deporek_id="+deporek_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#norek").empty();
                                $("#norek").append('<option value="">Pilih Rekening</option>');
                                $.each(res,function(norek,norek){
                                    $("#norek").append('<option value="'+norek+'">'+norek+'</option>');
                                });
                            }else{
                                $("#norek").empty();
                            }
                        }
                    });
                }else{
                    $("#norek").empty();
                }
            });
        });
</script>

@endsection()