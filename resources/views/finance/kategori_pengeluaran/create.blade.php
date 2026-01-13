@extends('layouts.admin')

@section('title')
	<title>Create Spending</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Category</li>
        <li class="breadcrumb-item">Spending</li>
        <li class="breadcrumb-item active">Create Spending</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('sub_category_fin.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Create Spending</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                    
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Category Name
                                        <select name="kode_kategori" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($kategori as $row)
                                                <option value="{{ $row->id_categories }}" {{ old('kode_kategori') == $row->id_categories ? 'selected':'' }}>{{ $row->categories_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                    
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Sub Category Name
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>                                
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                    
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <button class="btn btn-primary btn-sm float-right">Save</button>
                                    </div>
                                    
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
@endsection