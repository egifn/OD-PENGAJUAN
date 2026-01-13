@section('js')
<script type="text/javascript">
    
    $('#budget').maskMoney({thousands:',', decimal:'.', precision:0});

    $(function(){
        $('#kode_perusahaan').change(function(){
            var perusahaan_id = $(this).val();
            if(perusahaan_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax_depo_budget?perusahaan_id="+perusahaan_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#kode_depo").empty();
                            $("#kode_depo").append('<option value="">Pilih</option>');
                            $.each(res,function(nama,kode){
                                $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#kode_depo").empty();
                        }
                    }
                });
            }else{
                $("#kode_depo").empty();
            }
        });
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Tambah Budget ATK</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Budget</li>
        <li class="breadcrumb-item active">Update Budget ATK</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('budget_atk/edit.edit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Update Budget ATK</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-2 mb-2" hidden>
                                        Kode Budget
                                        <input type="text" name="kode_budget" id="kode_budget" class="form-control" value="{{ $data_budget_update->kode_budget }}" required>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Wilayah
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                            <option value="{{ $data_budget_update->kode_perusahaan }}">{{ $data_budget_update->nama_perusahaan }}</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-">
                                        Depo
                                        <select name="kode_depo" id="kode_depo" class="form-control">
                                            <option value="{{ $data_budget_update->kode_depo }}">{{ $data_budget_update->nama_depo }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Divisi
                                        <select name="kode_divisi" id="kode_divisi" class="form-control">
                                            <option value="{{ $data_budget_update->kode_divisi }}">{{ $data_budget_update->nama_divisi }}</option>
                                                @foreach ($divisi as $row)
                                                <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Budget
                                        <input type="text" style="text-align: right" name="budget" id="budget" class="form-control" value="{{ number_format($data_budget_update->budget) }}" required>
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