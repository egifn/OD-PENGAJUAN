@section('js')
<script type="text/javascript">


</script>
@stop

@extends('layouts.auth')

@section('title')
    <title>Login</title>
@endsection

@section('content')
    <div class="row justify-content-center" >

        <div class="col-md-7">
            <div class="card-group">
                <div class="card p-4">
                    <!-- Untuk Login -->
                    <div class="card-body">
                        
                        <h1>Login</h1>
                        <p class="text-muted">Masuk ke akun Anda</p>
                        <hr>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-user"></i>
                                    </span>
                                </div>
                              
                               
                                <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" 
                                    type="text" 
                                    name="username"
                                    placeholder="Username" 
                                    value="{{ old('username') }}" 
                                    autofocus 
                                    required>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-lock"></i>
                                    </span>
                                </div>
                                <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                    type="password" 
                                    name="password"
									id="password"
                                    placeholder="Password" 
                                    required>
									<div class="input-group-append">
										<button class="input-group-text" id="togglePassword" type="button"><i class="icon-eye"></i></button>
									</div>
                            </div>

                            <div class="row">
                                @if (session('error'))
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                </div>
                                @endif

                                <div class="col-6">
                                    <button class="btn btn-primary px-4">Login</button>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-link px-0" type="button" name="isi_username" id="isi_username" data-toggle="modal" data-target="#myModalDepo">Lupa password?</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row" hidden>
                                <div class="col-6">
                                    {{-- <p>Belum punya akun? <button class="btn btn-link px-0" type="button" name="daftar" id="daftar" data-toggle="modal" data-target="#myModalDaftar">Daftar</button></p> --}}
                                    <p>Belum punya akun? <a href="{{ route('user_registrasi_luar.index') }}">Daftar</a></p>
                                </div>
                            </div>

                        </form>
						
						<script src="{{ asset('assets/js/togglePassword.js') }}"></script>
						
                    </div>
                </div>   

                <div class="modal fade bd-example-modal-lg" id="myModalDepo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" >
                        <div class="modal-content" style="background: #fff;">
                            <form action="{{ route('reset.reset') }}" method="post">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <br>
                                    
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-user"></i>
                                                </span>
                                            </div>
                                        
                                        
                                            <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" 
                                                type="text" 
                                                name="username"
                                                placeholder="Masukan Username Anda" 
                                                value="{{ old('username') }}" 
                                                autofocus 
                                                required>
                                        </div>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-lock"></i>
                                                </span>
                                            </div>
                                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                                type="password" 
                                                name="password"
                                                placeholder="Masukan Password baru sebagai pengganti" 
                                                required>
                                        </div>
                                    
                                </div>
                                <tr>
                                <div class="modal-header">
                                    <button class="btn btn-primary px-4" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade bd-example-modal-xl" id="myModalDaftar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" >
                        <div class="modal-content" style="background: #fff;">
                            <form action="#" method="post">
                                @csrf
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Daftar Pengguna</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <br>
                                    
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Nama Lengkap
                                            <input type="text" name="name" id="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Email
                                            <input type="text" name="email" id="email" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Name
                                            <div class="input-group">
                                                <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" readonly>
                                                <input id="id_employee" type="hidden" name="id_employee" value="{{ old('id_employee') }}" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalEmployee"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            kategori
                                            <input type="text" name="kategori" id="kategori" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Username
                                            <input type="text" name="username" id="username" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Password
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Perusahaan
                                            <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                                <option value="">Select</option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Depo
                                            <select name="kode_depo" id="kode_depo" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Divisi
                                            <select name="kode_divisi" id="kode_divisi" class="form-control">
                                                <option value="">Select</option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Sub Divisi
                                            <select name="kode_sub_divisi" id="kode_sub_divisi" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Type
                                            <select name="type" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Admin">Administrator</option>
                                                <option value="Bod">BOD</option> 
                                                <option value="Manager">Manager</option> 
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            
                                        </div>
                                        
                                        <div class="col-md-2 mb-2">
                                            <br>
                                        </div>
                                    </div>
                                    
                                </div>
                                <tr>
                                <hr>
                                <div class="modal-header">
                                    <button class="btn btn-primary px-4" type="submit" >Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- kotak sebelah kanan warna biru -->
                <!--
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <img class="navbar-brand-full" src="{{ asset('assets/img/tua_1.jpg') }}" alt="TUA Group">
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
@endsection