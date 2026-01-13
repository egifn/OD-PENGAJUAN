@section('js')
<script type="text/javascript">
       

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Edit Rekening</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Rekening</li>
        <li class="breadcrumb-item active">Edit Rekening</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('rekening_fin.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <!-- FORM INPUT NEW CATEGORY  -->
                    <div class="col-md-10">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Edit Rekening</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="kode_vendor_sp">Nama Vendor</label>
                                        <div class="input-group">
                                            <input id="nama_vendor" type="text" name="nama_vendor" class="form-control" value="{{ $rekening->nama_vendor }}" readonly>
                                            <input id="kode_vendor" type="hidden" name="kode_vendor" value="{{ $rekening->kode_vendor }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="an">Nama Rekening</label>
                                        <input type="text" id="atas_nama" name="atas_nama" class="form-control" value="{{ $rekening->atas_nama }}" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <label for="name">Bank Terdaftar</label>
                                        <input type="text" id="bank_terdaftar" name="bank_terdaftar" class="form-control" value="{{ $rekening->nama_bank }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="kode_bank">Bank</label>
                                        <select name="kode_bank" class="form-control">
                                            <option value="{{ $rekening->kode_bank }}">{{ $rekening->nama_bank }}</option>
                                            @foreach ($bank as $rowbank)
                                                <option value="{{ $rowbank->kode_bank }}" {{ old('kode_bank') == $rowbank->kode_bank ? 'selected':'' }}>{{ $rowbank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                       
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        <label for="name">Id Rekening</label>
                                        <input type="text" id="id_rek" name="id_rek" class="form-control" value="{{ $rekening->id }}" required>
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="name">No Rekening</label>
                                        <input type="text" id="norek" name="norek" class="form-control" value="{{ $rekening->norek }}" required>
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10 mb-2">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $rekening->keterangan }}">
                                    </div>
                                </div>

                                <br> 
                                
                                <div class="form-group">
                                    <button class="btn btn-success btn-sm">Simpan Perubahan</button>
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