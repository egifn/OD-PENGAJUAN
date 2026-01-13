@section('js')
<script type="text/javascript">

    $(document).ready(function(){
        $('#lookup_coa').on('click', 'tbody tr', function(e){
            e.preventDefault();
            $('#transaksi').val($(this).find('td').next().html());
        });
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>COA Transaction</title>
    
    
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">COA Transaction</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                COA Transaction
                                <a href="{{ route('coa_transaction.create') }}" class="btn btn-primary btn-sm float-right">Add New COA Transaction</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <!-- <table class="table table-hover table-bordered"> -->
                                        <div style="width:100%;">
                                            <table id="lookup_coa" class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Transaction Name</th>
                                                        <th hidden>Debet</th>
                                                        <th hidden>Credit</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($account as $val)
                                                    <tr>
                                                        <td>{{ $val->no }}</td>
                                                        <td>{{ $val->nama_transaksi }}</td>
                                                        <td hidden>{{ $val->debit_1 }}</td>
                                                        <td hidden>{{ $val->kredit_1 }}</td>
                                                        <td align="center">
                                                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">Data Not Found</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            Transaction
                                            <input type="text" name="transaksi" id="transaksi" class="form-control" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            Debet Id
                                            <input type="text" name="debit_id" id="debit_id" class="form-control" value="" readonly>
                                        </div>

                                        <div class="col-md-7 mb-2">
                                            Debet Name
                                            <input type="text" name="debit_name" id="debit_name" class="form-control" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 mb-2">

                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Credit Id
                                            <input type="text" name="kredit_id" id="kredit_id" class="form-control" value="" readonly>
                                        </div>

                                        <div class="col-md-7 mb-2">
                                            Credit Name
                                            <input type="text" name="kredit_name" id="kredit_name" class="form-control" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            
                            
                          
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</main>


@endsection