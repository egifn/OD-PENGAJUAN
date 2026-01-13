@section('js')
<script type="text/javascript">
   $(document).on('click', '.pilih_vendor', function (e) {
                document.getElementById("nama_vendor").value = $(this).attr('data-nama_vendor');
                document.getElementById("kode_vendor").value = $(this).attr('data-kode_vendor');
                $('#myModal').modal('hide');
    });

    $(document).on('click', '.pilih_vendor_sp', function (e) {
                document.getElementById("nama_vendor_sp").value = $(this).attr('data-nama_vendor_sp');
                document.getElementById("kode_vendor_sp").value = $(this).attr('data-kode_vendor_sp');
                $('#myModal_sp').modal('hide');
    });

    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("rekening_fin/action_vendor.actionVendor") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_vendor', function(){
            var query = $(this).val();
            fetch_vendor_data(query);
        });
    });

    $(document).ready(function(){
        fetch_vendorsp_data();
        function fetch_vendorsp_data(query = '')
        {
            $.ajax({
                url:'{{ route("rekening_fin/action_vendor_sp.actionVendorSp") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_sp tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_vendor_sp', function(){
            var query = $(this).val();
            fetch_vendorsp_data(query);
        });
    });

    $(document).ready(function(){
        if ($("input[name='vendor']:checked").val() == "non sparepart" ) {
            $("#form-input-sp").hide();
        }else{
            $("#form-input-non").hide();
        }
        var disabled = false;
        $(".detail").click(function(){ 
             if ($("input[name='vendor']:checked").val() == "non sparepart" ) {
                $("#form-input-non").slideDown("fast");
                $("#form-input-sp").slideUp("fast");  
             }else{
                $("#form-input-non").slideUp("fast"); 
                $("#form-input-sp").slideDown("fast");
             }

        });
    });

    

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Tambah Rekening</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Rekening</li>
        <li class="breadcrumb-item active">Tambah Rekening</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('rekening_fin.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-10">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Rekening</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-2 mb-2">
                                       <input name="vendor" type="radio" id="non_sparepart" value="non sparepart" class="detail" checked="true"  />
                                       Non Sparepart
                                    </div>
                                    <div class="col-md-2 mb-2">
                                       <input name="vendor" type="radio" id="sparepart" value="sparepart" class="detail"  />
                                       Sparepart
                                    </div>
                                </div>

                                <div id="form-input-non">
                                <div id="form-input-non" class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="kode_vendor">Nama Vendor</label>
                                        <div class="input-group">
                                            <input id="nama_vendor" type="text" class="form-control" readonly >
                                            <input id="kode_vendor" type="hidden" name="kode_vendor" value="{{ old('kode_vendor') }}"  readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal"><b>Cari Vendor...</b></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="an">Nama Rekening</label>
                                        <input type="text" name="atas_nama" class="form-control">
                                    </div>
                                </div>
                                </div>

                                <div id="form-input-sp">
                                <div id="form-input-sp" class="row">
                                    <div class="col-md-6 mb-2">
                                    
                                        <label for="kode_vendor_sp">Nama Vendor</label>
                                        <div class="input-group">
                                            <input id="nama_vendor_sp" type="text" class="form-control" readonly>
                                            <input id="kode_vendor_sp" type="hidden" name="kode_vendor_sp" value="{{ old('kode_vendor_sp') }}" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_sp"><b>Cari Vendor...</b></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="an_sp">Nama Rekening</label>
                                        <input type="text" name="atas_nama_sp" class="form-control">
                                    </div>
                                </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="name">No Rekening</label>
                                        <input type="text" name="norek" class="form-control" required>
                                        
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="kode_bank">Bank</label>
                                    
                                        <select name="kode_bank" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($bank as $rowbank)
                                                <option value="{{ $rowbank->kode_bank }}" {{ old('kode_bank') == $rowbank->kode_bank ? 'selected':'' }}>{{ $rowbank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                       
                                    </div>
                                </div>
								
								<div class="row">
                                    <div class="col-md-10 mb-2">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                                    </div>
                                </div>

                                <br> 
                                
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">S i m p a n</button>
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor Non Sparepart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_vendor" id="search_vendor" class="form-control" placeholder="Cari Vendor . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Vendor</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_sp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor Sparepart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_vendor_sp" id="search_vendor_sp" class="form-control" placeholder="Cari Vendor . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup_sp" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Vendor</th>
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