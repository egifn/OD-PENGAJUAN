@section('js')

@stop

@extends('layouts.admin')

@section('title')
	<title>Get in - Get out</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Get In - Get Out</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Get In - Get Out</h4>
                        </div>
                        <div class="card-body">
                            <!-- <form action="{{ route('kredit.rekeningcari') }}" method="get"> -->
                        	<form action="{{ route('getin_getout/cari.cari') }}" method="get" enctype="multipart/form-data">
                        		@csrf
                        		<div class="row">
                                    <div class="col-md-3 mb-4">
                                        BKB
                                        <input type="text" name="no_bkb" id="no_bkb" class="form-control" value="" >
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        
                                        <br>
                                        <button class="btn btn-primary" type="submit">Search</button>
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div> 
                                </div>
                                <div class="card-body">
                                    
                                    <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                        <div style="border:1px white;overflow-y:scroll;">
                                            <table id="table_dms" class="table table-bordered table-striped table-sm" >
                                                <thead>
                                                    <tr>
                                                        <th>Doc Id</th>
                                                        <th>Date</th>
                                                        <th>VehicleId</th>
                                                        <th>Product Id</th>
                                                        <th>Product Name</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($bkb_data as $valdms) 
                                                    <tr>
                                                        <td>{{ $valdms->szDocId }}</td>
                                                        <td>{{ $valdms->dtmDoc }}</td>
                                                        <td>{{ $valdms->szVehicleId }}</td>
                                                        <td>{{ $valdms->szProductId }}</td>
                                                        <td>{{ $valdms->szName }}</td>
                                                        <td align="right">{{ $valdms->decQty }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">Data Not Found</td>
                                                    </tr>
                                                    @endforelse
                                           
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>


                        	</form>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



@endsection