@section('js')


<script type="text/javascript">

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("warehouse.store_1") }}',
            type: 'post',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    $(function(){
        $('#kode_perusahaan').change(function(){
            var perusahaan_id = $(this).val();
            if(perusahaan_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax_depo_warehouse?perusahaan_id="+perusahaan_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#kode_depo").empty();
                            $("#kode_depo").append('<option value="">Select</option>');
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
    <title>Warehouse</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Warehouse</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Warehouse
                                <a href="{{ route('warehouse.create') }}" class="btn btn-primary btn-sm float-right">Add Warehouse</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            @if(Auth::user()->kode_divisi == '22')
                                <form action="{{ route('warehouse.cari') }}" method="get" >
                                    <div class="input-group mb-3 col-md-6 float-right"> 
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                            <option value="">Perusahaan</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                        &nbsp
                                        <select name="kode_depo" id="kode_depo" class="form-control" required>
                                            <option value="">Depo</option>
                                        </select>
                                        &nbsp
                                        <button class="btn btn-primary" type="submit" id="cari" name="cari">C a r i</button>
                                    </div>    
                                </form>
                            @endif

                            <form action="{{ route('warehouse.store_1') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Warehouse Id</th>
                                                <th hidden>Company Id</th>
                                                <th>Company</th>   
                                                <th hidden>Depo Id</th>
                                                <th>Depo</th>
                                                <th hidden>Product Id</th>
                                                <th>Product Name</th>
                                                <th hidden>Zona Id</th>
                                                <th>Zona</th>
                                                <th hidden>Sub Zona Id</th>
                                                <th>Sub Zona</th>
                                                <th >Qty</th>    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($warehouse as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td hidden><!--{{ $val->id_warehouse }} -->
                                                    <input type="text" class="form-control" name="id_warehouse[]" id="id_warehouse" style="font-size: 13px; text-align: right; width: 100%;" value="{{ $val->id_warehouse }}">
                                                </td>
                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kode_produk }}</td>
                                                <td>{{ $val->nama_produk }}</td>
                                                <td hidden>{{ $val->kode_area }}</td>
                                                <td>{{ $val->nama_area }}</td>
                                                <td hidden>{{ $val->kode_sub_area }}</td>
                                                <td>{{ $val->nama_sub_area }}</td>
                                                @if(Auth::user()->kode_divisi == '22')
                                                    <td >
                                                        <input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right; width: 100%;" value="{{ $val->qty }}">
                                                    </td>
                                                @else
                                                    <td > {{ $val->qty }}
                                                    <!--<input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right; width: 100%;" value="{{ $val->qty }}">-->
                                                    </td>
                                                @endif
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="13" class="text-center">Data not found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            
                            @if(Auth::user()->kode_divisi == '22')
                                <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">U p d a t e</button>
                            @else
                                <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right" hidden>U p d a t e</button>
                            @endif

                         </form>
                        </div>

                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
        </div>
    </div>
</main>

@endsection

