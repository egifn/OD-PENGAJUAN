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


 $(document).on('click', '.add_button', function (e) {
        var no_awal = document.getElementById("awal").value;
        var no_akhir = document.getElementById("jumlah_data").value;

        
        for(i=no_awal; i <=no_akhir; i++){
            if(i <= 9){
                var nol = "00000";
            }else if(i <= 99){
                var nol = "0000";
            }else if(i <= 999){
                var nol = "000";
            }else if(i <= 9999){
                var nol = "00";
            }else if(i <= 99999){
                var nol = "0";
            }else{
                
            }
            var tabel = document.getElementById("tabelinput");
            var row = tabel.insertRow(1);

            var kode_perusahaan = document.getElementById("kode_perusahaan_head").value;
            // var nama_perusahaan = document.getElementById("perusahaan").value;
            // var id_cek = document.getElementById("buku").value;
            // var no_rek = document.getElementById("norek").value;
            // var kode_bank = document.getElementById("kode_bank").value;
            // var nama_bank = document.getElementById("nama_bank").value;
            // var ket = document.getElementById("ket").value;
            // var tgl = document.getElementById("tgl").value;
            // var kategori = document.getElementById("kategori").value;

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            // var cell3 = row.insertCell(2);
            // var cell4 = row.insertCell(3);
            // var cell5 = row.insertCell(4);
            // var cell6 = row.insertCell(5);
            // var cell7 = row.insertCell(6);
            // var cell8 = row.insertCell(7);

            cell1.innerHTML = '<input type="text" class="form-control" name="kode_id[]" id="kode_id" style="font-size:13px;" value="'+i+'" readonly />';
            cell2.innerHTML = '<input type="text" class="form-control" name="kode_perusahaan[]" id="perusahaan" style="font-size: 13px;" value="'+kode_perusahaan+'" readonly>'//b;
            
        }
        
    });

    function show_my_pdf() {
        var retVal = confirm("Do you want to continue to print?");
        if( retVal == true ) {
            window.open('{{ route('qr_code.pdf', $kode) }}', '_blank');    
        }
    }

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Create Qr Code</title>
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
        <form action="{{ route('qr_code.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Buat Qr Code</h4>
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
                                    <div class="col-md-3 mb-2" hidden>
                                        No Awal
                                        <input type="text" name="awal" id="awal" class="form-control" value="1" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Jumlah
                                        <input type="number" name="jumlah_data" id="jumlah_data" class="form-control" value="" required>
                                    </div>
                                    <div class="col-md-3 mb-2" >
                                        Perusahaan
                                        <select name="kode_perusahaan_head" id="kode_perusahaan_head" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <br>
                                        <!-- <button class="btn btn-primary px-4"> Add </button> -->
                                        <a class="btn btn-warning add_button" href="javascript:void(0);" id="add_button" title="Add field"><b>T a m b a h</b></a>
                                    </div>
                                    

                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Id
                                        <input type="text" name="kode_id" id="kode_id" class="form-control" value="{{ $kode }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2" hidden>
                                        Nama Toko
                                        <input type="text" name="nama_toko" id="nama_toko" class="form-control">
                                        
                                        <select name="kode_divisi" id="kode_divisi" class="form-control" hidden>
                                            <option value="">Select</option>
                                            @foreach ($divisi as $row)
                                                <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                            @endforeach 
                                        </select>
                                    
                                    </div>

                                    
                                </div>
                                
                                

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Company
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Telepon
                                        <input type="text" name="telepon" id="telepon" class="form-control">
                                    </div>
                                    

                
                                </div>
                               
                                
                                
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Depo
                                        <select name="kode_depo" id="kode_depo" class="form-control">
                                            <option value="">Select</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Alamat
                                        <textarea name="alamat" id="alamat" rows="1" class="form-control"></textarea>
                                    </div>
                                    
                    
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        
                                    </div>
                                    
                                    
                                </div>
                                
                        	<!-- </form> -->
                          
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;height:180px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Perusahaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-primary btn-sm float-right" onclick="show_my_pdf()"><b>S i m p a n</b></button>

                                        <a href="" target="_blank" class="btn btn-warning btn-sm" hidden>P r i n t</a>
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