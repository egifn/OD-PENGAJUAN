@section('js')
<script type="text/javascript">


</script>
@stop

@extends('layouts.auth')

@section('title')
    <title>Pendaftaran</title>
@endsection

@section('content')
    <div class="row justify-content-center" >

        <div class="col-md-7">
            <div class="card-group">
                <div class="card p-4">
                    <!-- Untuk Login -->
                    <div class="card-body">
                        
                        <h1>Pendaftaran Pengguna</h1>
                        <p class="text-muted"></p>
                        <hr>
                        <form action="{{ route('user_registrasi_luar.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-2 mb-2">     
                                
                                </div>
                                <div class="col-md-8 mb-2">
                                    Nama Lengkap
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-2" hidden>
                                    Email
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                                {{-- <div class="col-md-3 mb-2">
                                    Name
                                    <div class="input-group">
                                        <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" readonly>
                                        <input id="id_employee" type="hidden" name="id_employee" value="{{ old('id_employee') }}" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalEmployee"> <span class="fa fa-search"></span></button>
                                        </span>
                                    </div>
                                </div> --}}
                                <div class="col-md-3 mb-2" hidden>
                                    kategori
                                    <input type="text" name="kategori" id="kategori" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 mb-2">     
                                
                                </div>

                                <div class="col-md-4 mb-2">
                                    Username
                                    <input type="text" name="username" id="username" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    Password
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    
                                </div>

                                <div class="col-md-4 mb-2">
                                    Perusahaan
                                    <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($perusahaan as $row)
                                            <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    Depo
                                    <select name="kode_depo" id="kode_depo" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($depo as $row)
                                            <option value="{{ $row->kode_depo }}" {{ old('kode_perusahaan') == $row->kode_depo ? 'selected':'' }}>{{ $row->nama_depo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    
                                </div>

                                <div class="col-md-4 mb-2">
                                    Divisi
                                    <select name="kode_divisi" id="kode_divisi" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($divisi as $row)
                                            <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                        @endforeach 
                                         
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    Sub Divisi
                                    <select name="kode_sub_divisi" id="kode_sub_divisi" class="form-control">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    
                                </div>

                                <div class="col-md-4 mb-2">
                                    Tipe
                                    <select name="type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Manager">Manager</option> 
                                    </select>
                                </div>

                                <div class="col-md-1 mb-2">
                                    
                                </div>
                                
                                <div class="col-md-2 mb-2">
                                    <br>
                                    <button class="btn btn-primary px-4" type="submit"> Daftar </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>   

            </div>
        </div>
    </div>
@endsection