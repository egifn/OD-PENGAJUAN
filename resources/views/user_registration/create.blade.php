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
    $('#kode_perusahaan').change(function(){
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
	<title>User Registration</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">User Registration</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">User Registration</h4>
                        </div>
                        <div class="card-body">

                        	<form action="{{ route('user_registration.store') }}" method="post" enctype="multipart/form-data">
                        		@csrf
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <img class="navbar-brand-full" src="{{ asset('assets/img/tua_1.jpg') }}" width="89" height="25" alt="TUA Group">
                                    </div>
                                </div>
                        		
                                @if(Auth::user()->kode_divisi == '23') <!-- Jika korsis-->
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Nama
                                            <input type="text" name="name" id="name" class="form-control" required>
                                        </div>
										
										<div class="col-md-3 mb-2">
                                            Hak Akses
                                            <select name="akses" id="akses" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Admin">Admin</option>
                                                <option value="User">User</option>
                                  
                                            </select>
                                        </div>
										
                                        <div class="col-md-3 mb-2" hidden>
                                            Email
                                            <input type="text" name="email" id="email" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Name
                                            <div class="input-group">
                                                <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" readonly>
                                                <input id="id_employee" type="hidden" name="id_employee" value="{{ old('id_employee') }}" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalEmployee"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            kategori
                                            <input type="text" name="kategori" id="kategori" class="form-control">
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Nama Lengkap
                                            <input type="text" name="name" id="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Email
                                            <input type="text" name="email" id="email" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Name
                                            <div class="input-group">
                                                <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" readonly>
                                                <input id="id_employee" type="hidden" name="id_employee" value="{{ old('id_employee') }}" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalEmployee"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            kategori
                                            <input type="text" name="kategori" id="kategori" class="form-control">
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Username
                                        <input type="text" name="username" id="username" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Password
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
									
									@if(Auth::user()->kode_divisi == '23') <!-- Jika korsis-->
										<div class="col-md-3 mb-2" hidden>
											Depo
											<select name="kode_depo" id="kode_depo" class="form-control">
												<option value="">Select</option>
											</select>
										</div>
									@else
										<div class="col-md-3 mb-2">
											Depo
											<select name="kode_depo" id="kode_depo" class="form-control">
												<option value="">Select</option>
											</select>
										</div>
									@endif
                                    

                                    
                                </div>
                               
                                
                                @if(Auth::user()->kode_divisi == '23') <!-- Jika korsis-->
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Divisi
                                            <select name="kode_divisi" id="kode_divisi" class="form-control">
                                                <option value="">Select</option>
                                                @foreach ($divisi as $row)
                                                    <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Sub Divisi
                                            <select name="kode_sub_divisi" id="kode_sub_divisi" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>

                                        <div class="col-md-3 mb-2" hidden>
                                            Type
                                            <input type="text" name="type" id="type" class="form-control" value="Admin" required>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        
                                        <div class="col-md-2 mb-2">
                                            <br>
                                            <button class="btn btn-primary px-4"> Add </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Divisi
                                            <select name="kode_divisi" id="kode_divisi" class="form-control">
                                                <option value="">Select</option>
                                                @foreach ($divisi as $row)
                                                    <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Sub Divisi
                                            <select name="kode_sub_divisi" id="kode_sub_divisi" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Type
                                            <select name="type" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Admin">Administrator</option>
                                                <option value="Bod">BOD</option> 
                                                <option value="Manager">Manager</option> 
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            
                                        </div>
                                        
                                        <div class="col-md-2 mb-2">
                                            <br>
                                            <button class="btn btn-primary px-4"> Add </button>
                                        </div>
                                    </div>
                                @endif
                                
                                
                        	</form>
                          
                        </div>
                    </div>
                </div>
            </div>
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