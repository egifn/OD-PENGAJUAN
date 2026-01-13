@section('js')
<script type="text/javascript">
    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById('kode_supp').value = $(this).attr('data-kode_vendor')
        document.getElementById('supplier').value = $(this).attr('data-nama_vendor')

        $('#myModalsupp').modal('hide');
    });

    $(document).on('click', '.pilih_kategori', function(e) {
        document.getElementById('kode_kategori').value = $(this).attr('data-kode')
        document.getElementById('kategori').value = $(this).attr('data-nama')

        $('#myModal_kategori').modal('hide');
    });

    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("vendor_sp/action_vendor.actionVendor") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_vendor tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_vendor', function(){
            var query = $(this).val();
            fetch_vendor_data(query);
        });
    });

    $(document).ready(function(){
        fetch_kategori_data();
        function fetch_kategori_data(query = '')
        {
            $.ajax({
                url:'{{ route("vendor_sp/action_category.actionKategori") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_Kategori tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_kategori', function(){
            var query = $(this).val();
            fetch_kategori_data(query);
        })
    });
</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Add New Vendor</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Sparepart Vendor</li>
        <li class="breadcrumb-item active">Add New Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('vendor_sp.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Add New Vendor</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-1 mb-2">
                                        ID
                                        <input type="text" name="kode_supp" id="kode_supp" class="form-control" value="" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Vendor
                                        <div class="input-group">
                                            <input name="supplier" id="supplier" type="text" class="form-control" readonly required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalsupp"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Group
                                        <select name="jenis" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="A1">A1</option>
                                            <option value="A2">A2</option>
                                            <option value="A3">A3</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                         Category
                                        <div class="input-group">
                                            <input id="kategori" type="text" class="form-control" readonly required>
                                            <input id="kode_kategori" type="hidden" name="kode_kategori" value="{{ old('kode_kategori') }}" required readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_kategori"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    
                                    <div class="col-md-2 mb-2">
                                        Faktur Pajak
                                        <select name="faktur" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="PKP">PKP</option>
                                            <option value="Non PKP">Non PKP</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2">

                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Action
                                        <br>
                                        <button class="btn btn-primary btn-sm">Save</button>
                                    </div>

                                </div>

                                <div class="row">
                                
                                </div>

                                <div class="row">
                                    
                                </div>
                                
                                <br> 
                                
                                <div class="form-group" align="right">
                                    
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

<div class="modal fade bd-example-modal-lg" id="myModalsupp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_vendor" id="cari_vendor" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_vendor" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Supplier</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_kategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_kategori" id="cari_kategori" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_Kategori" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
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