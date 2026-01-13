@section('js')
<script type="text/javascript">

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>User Registration</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Tarif BBM</li>
        <li class="breadcrumb-item active">Update Tarif BBM</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('tarif_bbm/edit.edit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Update Tarif BBM</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-2 mb-2" hidden>
                                        Id
                                        <input type="text" name="id_tarif" id="tarif" class="form-control" value="{{ $data_tarif_bbm_update->id }}" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Dari Depo
                                        <select name="dari_kode_depo" id="dari_kode_depo" class="form-control">
                                            <option value="{{ $data_tarif_bbm_update->kd_dari_depo }}">{{ $data_tarif_bbm_update->dari_depo }}</option>
                                            @foreach ($depo as $row)
                                                <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected':'' }}>{{ $row->nama_depo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-">
                                        Ke Depo
                                        <select name="ke_kode_depo" id="ke_kode_depo" class="form-control">
                                            <option value="{{ $data_tarif_bbm_update->kd_ke_depo }}">{{ $data_tarif_bbm_update->ke_depo }}</option>
                                            @foreach ($depo as $row)
                                                <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected':'' }}>{{ $row->nama_depo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Kendaraan
                                        <select name="kendaraan" id="kendaraan" class="form-control">
                                            <option value="{{ $data_tarif_bbm_update->kendaraan }}">{{ $data_tarif_bbm_update->kendaraan }}</option>
                                            <option value="Mobil">Mobil</option>
                                            <option value="Motor">Motor</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Uang Bensin
                                        <input type="text" name="uang_bensin" id="uang_bensin" class="form-control" value="{{ $data_tarif_bbm_update->uang }}" required>
                                    </div>

                                    <div class="col-md-12 mb-2" align="right">
                                        <br>
                                        <button class="btn btn-primary">U p d a t e</button>
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