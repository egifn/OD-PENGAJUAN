@section('js')
<script type="text/javascript">
    

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Ubah Username & Password</title>
@endsection

@section('content')


    
<main class="main">
   
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Ubah Username & Password</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('ubah_password/edit.edit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Ubah Username & Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Nama
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $data_user->name }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Username
                                        <input type="text" name="id_user" id="id_user" class="form-control" value="{{ $data_user->id }}" required readonly hidden>
                                        <input type="text" name="username" id="username" class="form-control" value="{{ $data_user->username }}" required>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                
                                    </div>

                                    <div class="col-md-6 mb-">
                                        Kata Sandi/Password Baru
                                        <input type="text" name="password" id="password" class="form-control" placeholder="Masukan kata sandi/password baru..." value="" required>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <button class="btn btn-success">S i m p a n</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>




@endsection

@section('script')



@endsection




