@section('js')
<script type="text/javascript">
   

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Edit Vendor</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Vendor</li>
        <li class="breadcrumb-item active">Edit Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('vendor_fin.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Edit Vendor</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Kode Vendor
                                        <input type="text" name="kode" class="form-control" value="{{ $vendor->kode_vendor }}" required readonly>
                                        
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Vendor
                                        <input type="text" name="vendor_name" class="form-control" value="{{ $vendor->nama_vendor }}" required>
                    
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Contact Person
                                        <input type="text" name="cp" class="form-control" value="{{ $vendor->contact_person }}" required>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Jabatan
                                        <input type="text" name="position" class="form-control" value="{{ $vendor->jabatan }}" required>
                                        
                                    </div>
                                    
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Telepon/HP
                                        <input type="text" name="telphone" class="form-control" value="{{ $vendor->telp }}" required>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Fax
                                        <input type="text" name="fax" class="form-control"  value="{{ $vendor->fax }}" required>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Email
                                        <input type="text" name="email" class="form-control" value="{{ $vendor->email }}" >
                                        
                                    </div>

                                   

                                    <div class="col-md-3 mb-2" hidden>
                                        Approved By
                                        <input type="text" name="approved" class="form-control" >
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Start Date
                                        <input id="start_date" type="date" class="form-control" name="start_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" >
                                        
                                    </div>
                                    
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Status 1
                                        <input type="text" name="status_1" class="form-control" value="{{ $vendor->status_1 }}" required>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Status 2
                                        <input type="text" name="status_2" class="form-control" value="{{ $vendor->status_2 }}" required>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        TOP
                                        <input type="text" name="top" class="form-control" value="{{ $vendor->top }}" required>
                                        
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Approved Date
                                        <input id="approved_date" type="date" class="form-control" name="approved_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}"  >
                                        
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        End Date
                                        <input id="end_date" type="date" class="form-control" name="end_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}"  >
                                        
                                    </div>

                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Alamat
                                        <textarea name="address" class="form-control" value="{{ $vendor->alamat }}" ></textarea>
                                       
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Memo
                                        <textarea name="memo" class="form-control" value="{{ $vendor->memo }}"></textarea>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Keterangan
                                        <textarea name="ket" class="form-control" value="{{ $vendor->keterangan }}"></textarea>
                                        
                                    </div>

                                    

            
                                </div>

                                <div class="row">
                                   

                                    <div class="col-md-3 mb-2" hidden>
                                        Memo Date
                                        <input id="memo_date" type="date" class="form-control" name="memo_date" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}">
                                        
                                    </div>
                                    
                                </div>
                                
                                <br> 
                                
                                <div class="form-group" align="right">
                                   
                                    <button class="btn btn-success btn-sm">Simpan Perubahan</button>
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