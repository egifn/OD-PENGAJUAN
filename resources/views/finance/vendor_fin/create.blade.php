@section('js')
<script type="text/javascript">
   $(document).on('click', '.pilih', function (e) {
                document.getElementById("nama_vendor").value = $(this).attr('data-nama_vendor');
                document.getElementById("kode_vendor").value = $(this).attr('data-kode_vendor');
                $('#myModal').modal('hide');
    });

    
    $(function () {
                $("#lookup").dataTable();
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
        <li class="breadcrumb-item">Vendor</li>
        <li class="breadcrumb-item active">Add New Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('vendor_fin.store') }}" method="post" enctype="multipart/form-data">
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
                                        ID
                                        <input type="text" name="kode" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('kode') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Vendor
                                        <input type="text" name="vendor_name" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('vendor_name') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Contact Person
                                        <input type="text" name="cp" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('cp') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Position
                                        <input type="text" name="position" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('position') }}</p>
                                    </div>
                                    
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Telphone
                                        <input type="text" name="telphone" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('telphone') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Status 1
                                        <input type="text" name="status_1" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('status_1') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Approved By
                                        <input type="text" name="approved" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('approved') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Start Date
                                        <input id="start_date" type="date" class="form-control" name="start_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                        <p class="text-danger">{{ $errors->first('start_date') }}</p>
                                    </div>
                                    
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Fax
                                        <input type="text" name="fax" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('fax') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Status 2
                                        <input type="text" name="status_2" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('status_2') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Approved Date
                                        <input id="approved_date" type="date" class="form-control" name="approved_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                        <p class="text-danger">{{ $errors->first('approved_date') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        End Date
                                        <input id="end_date" type="date" class="form-control" name="end_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                        <p class="text-danger">{{ $errors->first('end_date') }}</p>
                                    </div>

                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Address
                                        <textarea name="address" class="form-control" required></textarea>
                                        <p class="text-danger">{{ $errors->first('address') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Memo
                                        <textarea name="memo" class="form-control" required></textarea>
                                        <p class="text-danger">{{ $errors->first('memo') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        information
                                        <textarea name="ket" class="form-control" required></textarea>
                                        <p class="text-danger">{{ $errors->first('ket') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        TOP
                                        <input type="text" name="top" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('top') }}</p>
                                    </div>

            
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Email
                                        <input type="text" name="email" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Memo Date
                                        <input id="memo_date" type="date" class="form-control" name="memo_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                        <p class="text-danger">{{ $errors->first('memo_date') }}</p>
                                    </div>
                                    
                                </div>
                                
                                <br> 
                                
                                <div class="form-group" align="right">
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Vendor</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection