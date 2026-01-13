@section('js')
<script type="text/javascript">
    $(document).on('click', '.pilih_satu', function(e) {
        document.getElementById('kode_satu').value = $(this).attr('data-kode_lv1')
        document.getElementById('satu').value = $(this).attr('data-account_name')

        $('#myModalSatu').modal('hide');
    });
</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Coa</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Chart Of Account</li>
        <li class="breadcrumb-item active">COA Layer 2</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- BAGIAN INI AKAN MENG-HANDLE FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah layer</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('coa_2.store') }}" method="post">
                        		@csrf
                                <div class="form-group">
                                    <label for="supplier">Account Layer 1</label>
                                    <div class="input-group">
                                        <input id="satu" type="text" class="form-control" readonly required>
                                        <input id="kode_satu" type="hidden" name="kode_satu" value="{{ old('kode_satu') }}" required readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalSatu"> <span class="fa fa-search"></span></button>
                                        </span>
                                    </div>
                                    <p class="text-danger">{{ $errors->first('kode_satu') }}</p>
                                </div>

                        		<div class="form-group">
                        			<label for="kode">Kode</label>
        							<input type="text" name="kode" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('kode') }}</p>
                        		</div>
                        		<div class="form-group">
                        			<label for="acc">Account</label>
                                    <input type="text" name="acc" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('acc') }}</p>
                        		</div>

                                

                        		<div class="form-group">
        							<button class="btn btn-primary btn-sm">Tambah</button>
    							</div>

                        	</form>
                          
                        </div>
                    </div>
                </div>
                <!-- BAGIAN INI AKAN MENG-HANDLE FORM INPUT NEW CATEGORY  -->
              
                <!-- BAGIAN INI AKAN MENG-HANDLE TABLE LIST CATEGORY  -->
                <div class="col-md-8">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Account Layer 2</h4>
                        </div>
                        <div class="card-body">
                          	<!-- KETIKA ADA SESSION SUCCESS  -->
                            @if (session('success'))
                              <!-- MAKA TAMPILKAN ALERT SUCCESS -->
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th>kode</th>
                                            <th>Account</th>
                                            <th hidden>Tanggal Input</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($coa_2 as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->kode_lv2 }}</td>
                                            <td>{{ $val->account_name }}</td>
                                            <td hidden>{{ $val->created_at->format('d-M-Y') }}</td>
                                            
                                            <td>
                                                <form action="{{ route('coa_2.destroy', $val->kode_lv2) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                   
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No data available</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            {!! $coa_2->links() !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4" hidden>
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Import layer</h4>
                        </div>
                        <div class="card-body">
                          
                            <form action="{{ route('coa_2.storeData') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    
                                        <label for="">File (.xls, .xlsx)</label>
                                        <input type="file" name="file" class="form-control" value="{{ old('file') }}" required>
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                    
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">Import</button>
                                </div>

                            </form>
                          
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModalSatu" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Account Layer 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="lookup_satu" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Account Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coa_1 as $data)
                        <tr class="pilih_satu" data-kode_lv1="<?php echo $data->kode_lv1; ?>" data-account_name="<?php echo $data->account_name; ?>">
                            <td>{{$data->kode_lv1}}</td>
                            <td>{{$data->account_name}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection