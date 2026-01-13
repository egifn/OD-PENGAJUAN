@extends('layouts.admin')

@section('title')
    <title>Update Customer Due Date</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Accounting</li>
        <li class="breadcrumb-item">Customer Due Date</li>
        <li class="breadcrumb-item active">Update Customer Due Date</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Update Customer Due Date
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Termin</th>
                                                <th>Due Date</th>
                                                <th>Keterangan</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($duedate_detail as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->no_kontrabon }}</td>
                                            <td>{{ $val->tgl_kontrabon}}</td>
                                            <td>{{ $val->termin}}</td>
                                            <td>
                                                <input class="form-control" type="date" name="jt[]" id="jt_" value="{{ $val->jatuh_tempo }}"/>
                                            </td>
                                            <td>{{ $val->keterangan }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No data available</td>
                                        </tr>
                                       @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- PAGINATION  -->
                            
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection


