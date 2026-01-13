@extends('layouts.admin')

@section('title')
    <title>Tambah Rekening</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Rekonsiliasi</li>
        <li class="breadcrumb-item">Rekening</li>
        <li class="breadcrumb-item active">Tambah Rekening</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('rekening.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-10">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Rekening Baru</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="name">No.Rekening</label>
                                        <input type="text" name="norek" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('norek') }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2"">
                                        <label for="kode_bank">Bank</label>
                                    
                                        <select name="kode_bank" class="form-control">
                                            <option value="">Pilih</option>
                                            @foreach ($bank as $rowbank)
                                                <option value="{{ $rowbank->kode_bank }}" {{ old('kode_bank') == $rowbank->kode_bank ? 'selected':'' }}>{{ $rowbank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="row">
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
                        url:"/ajax_depo_rekening?perusahaandms_id="+perusahaandms_id,
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
</script>

@endsection()