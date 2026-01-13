@extends('layouts.admin')

@section('title')
	<title>Create Book of Cek/Giro</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Category</li>
        <li class="breadcrumb-item">Book of Cek/Giro</li>
        <li class="breadcrumb-item active">Create Book of Cek/Giro</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('category_fin.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Create Book of Cek/Giro</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Category Name
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>
                                
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