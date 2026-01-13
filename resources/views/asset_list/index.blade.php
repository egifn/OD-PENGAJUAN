@section('js')
<script type="text/javascript">
    fetchAllDataAsset();
    function fetchAllDataAsset(){
        $.ajax({
            type: "GET",
            url: "{{ route('asset_list/getDataAsset.getDataAsset') }}",
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 1;
                response.data.forEach(asset => {
                    tabledata += `<tr>`;
                    tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                    tabledata += `<td hidden>${asset.kode_asset}</td>`;
                    tabledata += `<td>${asset.nama_asset}</td>`;
                    tabledata += `<td hidden>${asset.id_user_input}</td>`;
                    tabledata += `<td>${asset.name}</td>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
            }
        });
    }

    $("#cari_asset").keyup(function() {
        let value = $("#cari_asset").val();
        if (this.value.length >= 2) {
            $.ajax({
                type: "GET",
                url: "{{ route('asset_list/getDataAsset.getDataAsset') }}",
                data: {
                    value: value
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 1;
                    response.data.forEach(asset => {
                        tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td hidden>${asset.kode_asset}</td>`;
                        tabledata += `<td>${asset.nama_asset}</td>`;
                        tabledata += `<td hidden>${asset.id_user_input}</td>`;
                        tabledata += `<td>${asset.name}</td>`;
                        tabledata += `</tr>`;
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }else{
            fetchAllDataAsset();
        }
    });

    $("#button_form_insert").click(function(e) {
        e.preventDefault();
        let nama_asset = $("#nama_asset").val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('asset_list/store.store') }}",
            data: {
                nama_asset: nama_asset,
            },
            success: function(response) {
                if(response.res === true) {
                    $("#nama_asset").val('');
                    fetchAllDataAsset();
                }else{
                    Swal.fire("Gagal!", "Data gagal disimpan.", "error");
                }
            }
        });
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>List Asset</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">List Asset</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                List Asset
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal"><i class="bi bi-plus"></i> Tambah Asset</button>
                            </h4>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('budget_atk.index') }}" method="get">
                                <div class="input-group mb-2 col-md-4 float-right">
                                    <input type="text" class="form-control" name="cari_asset" id="cari_asset" placeholder="Cari Data...">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th hidden>id</th>
                                            <th>Nama Asset</th>
                                            <th hidden>Id User Input</th>
                                            <th>Nama User Input</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
                                        
                                    </tbody>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="col-12">
                        <br>
                        <label for="inputNama" class="form-label">Nama Asset</label>
                        <input type="text" class="form-control" name="nama_asset" id="nama_asset" required>
                        <br>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="button_form_insert"><i class="bi bi-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="bi bi-x-lg"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>



@endsection


