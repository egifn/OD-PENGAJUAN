@extends('layouts.admin')

@section('title')
	<title>spending</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Category</li>
        <li class="breadcrumb-item active">spending</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Spending
                                <a href="{{ route('sub_category_fin.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
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
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th>ID</th>
                                            <th hidden>ID Category</th>
                                            <th>Sub Category</th>
                                            <th>Category</th>
                                            <th hidden>Kode User</th>
                                            <th>User</th>
                                            <th>Created At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pengeluaran as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->id_sub_categories }}</td>
                                            <td hidden>{{ $val->id_categories }}</td>
                                            <td>{{ $val->sub_categories_name }}</td>
                                            <td>{{ $val->categories_name }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td>{{ $val->created_at }}</td>
                                            <td align="center">
                                                <form action="{{ route('sub_category_fin.destroy', $val->id_sub_categories) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection