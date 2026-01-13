@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        fetch_data_category();
        function fetch_data_category(query = '')
        {
            $.ajax({
                url:'{{ route("import_pencapaian/action.actionSuratProgram") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_data_category(query);
        });
    });

    $(document).on('click', '.pilih', function(e){
        document.getElementById('no_surat').value = $(this).attr('data-no_surat')
        //document.getElementById('no_surat_tiv').value = $(this).attr('')
        document.getElementById('kode_perusahaan').value = $(this).attr('data-kode_perusahaan')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('id_program').value = $(this).attr('data-id_program')
        document.getElementById('nama_program').value = $(this).attr('data-nama_program')
        // alert(document.getElementById('id_pengeluaran').value);
        
        $('#myModal').modal('hide');
    });

    $("#batal").click(function(){
        $('#no_surat').val('');
        $('#no_surat_tiv').val('');
        $('#kode_perusahaan').val('');
        $('#kategori').val('');
        $('#id_program').val('');
        $('#nama_program').val('');
        $('#keterangan').val('');
        $('#file').val('');
        $('#file_upload_1').val('');
    });

    $("#button_hapus_import").click(function(){
        $('#file').val('');
    });

    $("#button_hapus_attch").click(function(){
        $('#file_upload_1').val('');
    });

    $(document).ready(function () {
        $("#data-form").submit(function (e) {
            e.preventDefault();

            var tableData = [];
            $("table tbody tr").each(function () {
                var rowData = [];
                $(this).find("td").each(function () {
                    rowData.push($(this).text());
                });
                tableData.push(rowData);
            });
            $("#data-field").val(JSON.stringify(tableData));

            $.ajax({
                type: "POST",
                url: $("#data-form").attr("action"),
                data: $("#data-form").serialize(),
                success: function (response) {
                    
                }
            });
        });
    });

</script>

@stop

@extends('layouts.admin')

@section('title')
    {{-- <title>Import Data DMS</title> --}}
    <title>Import Pencapaian</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Pencapaian Program</li>
        <li class="breadcrumb-item">Daftar Pencapaian</li>
        <li class="breadcrumb-item active">Import Pencapaian</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('import_pencapaian/edit.edit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Import Pencapaian
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        
                                        <button type="button" style="width: 205px;" id="caridatas" name="caridatas" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Cari Surat</button>

                                        <button type="button" id="batal" name="batal" class="btn btn-warning btn-sm" hidden>Batal/Reset</button>
                                    </div>  
                                   
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <strong>No Surat Distributor</strong>
                                        <input type="hidden" class="form-control" name="no_urut" id="no_urut" value="{{ $header->no_urut }}" readonly>
                                        <input type="hidden" class="form-control" name="no_surat_history" id="no_surat_history" value="{{ $header->no_surat }}" readonly>
                                        <input type="text" class="form-control" name="no_surat_dist" id="no_surat_dist" value="{{ $header->no_surat }}" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <strong>No Surat TIV</strong>
                                        <input type="hidden" class="form-control" name="no_surat_tiv_history" id="no_surat_tiv_history" value="{{ $header->no_surat_tiv }}" readonly>
                                        <input type="text" class="form-control" name="no_surat_tiv" id="no_surat_tiv" value="{{ $header->no_surat_tiv }}" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <strong>Perusahaan</strong>
                                        <input type="hidden" class="form-control" name="kode_perusahaan_history" id="kode_perusahaan_history" value="{{ $header->kode_perusahaan }}" readonly>
                                        <input type="text" class="form-control" name="kode_perusahaan" id="kode_perusahaan" value="{{ $header->kode_perusahaan }}" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <strong>Kategori</strong>
                                        <input type="hidden" class="form-control" name="kategori_history" id="kategori_history" value="{{ $header->kategori }}" readonly>
                                        <input type="text" class="form-control" name="kategori" id="kategori" value="{{ $header->kategori }}" readonly>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-2">
                                        <strong>Id Program</strong>
                                        <input type="hidden" class="form-control" name="id_program_history" id="id_program_history" value="{{ $header->id_program }}" readonly>
                                        <input type="text" class="form-control" name="id_program" id="id_program" value="{{ $header->id_program }}" readonly>
                                    </div> 
                                    
                                    <div class="col-md-10">
                                        <strong>Nama Program</strong>
                                        <input type="hidden" class="form-control" name="nama_program_history" id="nama_program_history" value="{{ $header->nama_program }}" readonly>
                                        <input type="text" class="form-control" name="nama_program" id="nama_program" value="{{ $header->nama_program }}" readonly>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Keterangan</strong>
                                        <input type="hidden" class="form-control" name="keterangan_history" id="keterangan_history" value="{{ $header->keterangan }}" required>
                                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ $header->keterangan }}" required>
                                    </div>                                      
                                </div>
                                <br>
                                <div class="table-responsive" hidden>
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <div style="width:100%;">
                                        <table class="table table-bordered table-hover table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>Tgl Import</th>
                                                    <th hidden >No Surat</th>
                                                    <th hidden>kode depo</th>
                                                    <th>Depo</th>
                                                    <th hidden>kode segmen</th>
                                                    <th>Segmen</th>
                                                    <th>Cluster</th>
                                                    <th>Kode Outlet</th>
                                                    <th>Outlet</th>
                                                    <th>Reward Distributor</th>
                                                    <th>Reward TIV</th>
                                                    <th>Total Reward</th>
                                                    <th hidden>Id User Input</th>
                                                    <th hidden>Nama User Input</th>
                                                    <th hidden>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($detail as $val)
                                                <tr>
                                                    <td>{{ $no }}
                                                        <input type="hidden" class="form-control" name="no[]" id="no" value="{{ $no }}">
                                                    </td>
                                                    <td hidden>{{ $val->tgl_import }}
                                                        <input type="hidden" class="form-control" name="tgl_import[]" id="tgl_import" value="{{ $val->tgl_import }}">
                                                    </td>
                                                    <td hidden>{{ $val->no_surat }}
                                                        <input type="hidden" class="form-control" name="no_surat[]" id="no_surat" value="{{ $val->no_surat }}">
                                                    </td>
                                                    <td hidden>{{ $val->kode_depo }}
                                                        <input type="hidden" class="form-control" name="kode_depo[]" id="kode_depo" value="{{ $val->kode_depo }}">
                                                    </td>
                                                    <td>{{ $val->nama_depo }}
                                                        <input type="hidden" class="form-control" name="nama_depo[]" id="nama_depo" value="{{ $val->nama_depo }}">
                                                    </td>
                                                    <td hidden>{{ $val->kode_segmen }}
                                                        <input type="hidden" class="form-control" name="kode_segmen[]" id="kode_segmen" value="{{ $val->kode_segmen }}">
                                                    </td>
                                                    <td>{{ $val->nama_segmen }}
                                                        <input type="hidden" class="form-control" name="nama_segmen[]" id="nama_segmen" value="{{ $val->nama_segmen }}">
                                                    </td>
                                                    <td>{{ $val->cluster }}
                                                        <input type="hidden" class="form-control" name="cluster[]" id="cluster" value="{{ $val->cluster }}">
                                                    </td>
                                                    <td>{{ $val->kode_outlet }}
                                                        <input type="hidden" class="form-control" name="kode_outlet[]" id="kode_outlet" value="{{ $val->kode_outlet }}">
                                                    </td>
                                                    <td>{{ $val->nama_outlet }}
                                                        <input type="hidden" class="form-control" name="nama_outlet[]" id="nama_outlet" value="{{ $val->nama_outlet }}">
                                                    </td>
                                                    <td align="right">{{ number_format($val->reward) }}
                                                        <input type="hidden" class="form-control" name="reward[]" id="reward" value="{{ $val->reward }}">
                                                    </td>
                                                    <td align="right">{{ number_format($val->reward_tiv) }}
                                                        <input type="hidden" class="form-control" name="reward_tiv[]" id="reward_tiv" value="{{ $val->reward_tiv }}">
                                                    </td>
                                                    <td align="right">{{ number_format($val->reward + $val->reward_tiv) }}
                                                        <input type="hidden" class="form-control" name="reward_total[]" id="reward_total" value="{{ $val->reward + $val->reward_tiv }}">
                                                    </td>
                                                    <td hidden></td>
                                                    <td hidden></td>
                                                    <td hidden></td>
                                                </tr>
                                                <?php $no++ ?>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">   
                                    <div class="col-md-12 mb-2">
                                        <strong>Import File Data Pencapaian (file *.xlsx, *.xls)</strong>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="file" id="file" >
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-danger" id="button_hapus_import" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                            </span>
                                        </div>
                                    </div>  
                                </div>
                                <br>
                                <div class="row" >
                                    <div class="col-md-12 mb-2">
                                        <div class="input-group mb-3">
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($data_pencapaian as $row)
													<strong>Attach file (Upload dokumen pendukung)</strong>
                                                    <tr>
                                                        <td><i>Attachment {{ $no }}:</i><br>
                                                            Dokumen Pendukung
                                                        </td>
                                                        <td>
                                                            <a href="{{url('images/'. $row->filename)}}">
                                                                {{ $row->filename}}
                                                            </a>
                                                            <input type="hidden" class="form-control" name="filename" id="filename" value="{{ $row->filename}}">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                            <input type="file" class="form-control" name="file_upload[]" id="file_upload_1">  
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    @empty
                                                    <tr>
                                                        <strong>Attach file (Upload dokumen pendukung)</strong>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" name="file_upload[]" id="file_upload_1" multiple>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-danger" id="button_hapus_attch" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                                            </span>
                                                        </div>   
                                                    </tr>   
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="hidden" name="data" id="data-field" value="">
                                        <button class="btn btn-success btn-sm float-right">P r o s e s</button>
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Surat Program</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No Surat Distributor</th>
                                <th>No Surat TIV</th>
                                <th>Perusahaan</th>
                                <th>Id Program</th>
                                <th>Nama Program</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection