@section('js')
<script type="text/javascript">

$(document).on('click', '.pilih', function(e) {
        document.getElementById('id_employee').value = $(this).attr('data-id')
        document.getElementById('nama_lengkap').value = $(this).attr('data-nama')
        document.getElementById('kategori').value = $(this).attr('data-kategori')

        $('#myModalEmployee').modal('hide');
});

$(document).ready(function(){
    fetch_employee_data();
    function fetch_employee_data(query = '')
    {
        $.ajax({
            url:'{{ route("user_registration/action_employee.actionEmployee") }}',
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
        fetch_employee_data(query);
    });
});

$(function(){
    $('#kd_perusahaan').change(function(){
        var perusahaan_id = $(this).val();
        if(perusahaan_id){
            $.ajax({
                type:"GET",
                url:"/ajax_depo_user?perusahaan_id="+perusahaan_id,
                dataType:'JSON',
                success: function(res){
                    if(res){
                        $("#kode_depo").empty();
                        $("#kode_depo").append('<option value="">Select</option>');
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
    $('#kode_divisi').change(function(){
        var divisi_id = $(this).val();
        if(divisi_id){
            $.ajax({
                type:"GET",
                url:"/ajax_divisi?divisi_id="+divisi_id,
                dataType:'JSON',
                success: function(res){
                    if(res){
                        $("#kode_sub_divisi").empty();
                        $("#kode_sub_divisi").append('<option value="">Select</option>');
                        $.each(res,function(nama,kode){
                            $("#kode_sub_divisi").append('<option value="'+kode+'">'+nama+'</option>');
                        });
                    }else{
                        $("#kode_sub_divisi").empty();
                    }
                }
            });
        }else{
            $("#kode_sub_divisi").empty();
        }
    });
});

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Edit Qr Code</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Qr Code</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="{{ route('qr_code/edit.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Edit Qr Code</h4>
                        </div>
                        <div class="card-body">

                        	<!-- <form action="{{ route('qr_code.store') }}" method="post" enctype="multipart/form-data"> -->
                        		@csrf
                                <div class="row" hidden>
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <img class="navbar-brand-full" src="{{ asset('assets/img/tua_1.jpg') }}" width="89" height="25" alt="TUA Group">
                                    </div>
                                </div>
                        		<div class="row">
                                    <div class="col-md-1 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Id
                                        <input type="text" name="kode_id" id="kode_id" class="form-control" value="{{ $data->id }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        Nama Toko
                                        <input type="text" name="nama_toko" id="nama_toko" class="form-control" value="{{ $data->nama }}">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Alamat
                                        <textarea name="alamat" id="alamat" rows="1" class="form-control">{{ $data->alamat }}</textarea>
                                    </div>

                                    
                                </div>
                                
                                

                                <div class="row">
                                    <div class="col-md-1 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                       <!--  <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                            <option value="{{ $data->nama_perusahaan }}">{{ $data->nama_perusahaan }}</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach
                                        </select> -->
                                        <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ $data->nama_perusahaan }}" readonly>
                                        <input type="text" name="kd_perusahaan" id="kd_perusahaan" class="form-control" value="{{ $data->kode_perusahaan }}" readonly hidden>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Telepon
                                        <input type="text" name="telepon" id="telepon" class="form-control" value="{{ $data->telepon }}">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Titik Lokasi 1 (Koordinat Lintang)
                                        <input type="text" name="koordinat_1" id="koordinat_1" class="form-control" style="text-align: right;" value="{{ $data->koordinat_lintang }}" >
                                    </div>
                                    
                                </div>
                               
                                
                                
                                <div class="row">
                                    <div class="col-md-1 mb-2">
                                        
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Depo
                                        <select name="kode_depo" id="kode_depo" class="form-control">
                                            <option value="{{ $data->kode_depo }}">{{ $data->nama_depo }}</option>
                                            @foreach ($depo as $row)
                                                <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected':'' }}>{{ $row->nama_depo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Biaya Sewa
                                        <input type="text" name="biaya_sewa" id="biaya_sewa" class="form-control" style="text-align: right;" value="{{ $data->biaya_sewa }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        Titik Lokasi 2 (Koordinat Bujur)
                                        <input type="text" name="koordinat_2" id="koordinat_2" class="form-control" style="text-align: right;" value="{{ $data->koordinat_bujur }}" >
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-1 mb-2">
                                        
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Nama SPV
                                        <!--<select name="spv" id="spv" class="form-control">
                                            <option value="{{ $data->kode_spv }}">{{ $data->kode_spv }}</option>
                                            <option value="SPV A">SPV A</option>
                                            <option value="SPV B">SPV B</option>
                                            <option value="SPV C">SPV C</option>
                                            <option value="SPV D">SPV D</option>
                                            <option value="SPV E">SPV E</option>
                                            <option value="SPV F">SPV F</option>
                                        </select> -->
                                        <input type="text" name="spv" id="spv" class="form-control" value="{{ $data->kode_spv }}" >
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Jenis
                                        <select name="jenis" id="jenis" class="form-control">
                                            <option value="{{ $data->jenis }}">{{ $data->jenis }}</option>
                                            <option value="Non TIV">Non TIV</option>
                                            <option value="TIV">TIV</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <br>
                                        <button class="btn btn-success px-4"> S i m p a n </button>
                                    </div>
                                    
                                    
                                </div>
                                
                        	<!-- </form> -->
                          
                        </div>
                    </div>
                </div>

            </div>
        </form>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModalEmployee" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Category</th>
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