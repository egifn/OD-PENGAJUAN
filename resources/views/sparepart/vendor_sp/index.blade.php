@extends('layouts.admin')

@section('title')
    <title>Sparepart Vendor</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Sparepart Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Sparepart Vendor
                                <a href="{{ route('vendor_sp.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
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
                                <!--<div style="width:400%;"> -->
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Group</th>
                                                <th>Sub Group</th>
                                                <th>Id</th>
                                                <th hidden>Kode_Kategori</th>
                                                <th>Category</th>
                                                <th hidden>Vendor Id</th>
                                                <th>Vendor Name</th>
                                                <th>Status</th>
                                                <th hidden>Created At</th>
                                                <th hidden>Input By</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($sparepart_vendor as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->kelompok }}</td>
                                            <td>{{ $val->kelompok }}-{{ $val->sub_kelompok }}</td>
                                            <td>{{ $val->kode_cat }}</td>
                                            <td hidden>{{ $val->sub_kelompok }}</td>
                                            <td>{{ $val->nama_kategori_vendor }}</td>
                                            <td hidden>{{ $val->kode_vendor }}</td>
                                            <td>{{ $val->nama_vendor }}</td>
                                            <td>{{ $val->status }}</td>
                                            <td hidden>{{ $val->created_at }}</td>
                                            <td hidden>{{ $val->id_user_input }}</td>
                                            <td align="center">
                                                <form action="#" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data Not Found</td>
                                        </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                <!-- </div> -->
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection