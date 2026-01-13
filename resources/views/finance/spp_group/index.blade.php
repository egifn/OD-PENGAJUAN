@extends('layouts.admin')

@section('title')
    <title>Daftar SPP</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">SPP Group</li>
        <li class="breadcrumb-item active">Daftar Pengajuan untuk SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Pengajuan untuk SPP
                                <a href="#" class="btn btn-primary btn-sm float-right" hidden>Buat SPP</a>
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12 mb-4">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#barang" role="tab" aria-controls="barang">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Barang Operasional</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#biaya" role="tab" aria-controls="biaya">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Biaya/Jasa</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#sparepart" role="tab" aria-controls="sparepart">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Sparepart</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#fleet" role="tab" aria-controls="fleet">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Fleet</b>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="barang" role="tabpanel"> 
                                        <div class="card-body">
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <div class="table-responsive">
                                                <!-- <table class="table table-hover table-bordered"> -->
                                                <div style="width:100%;">
                                                    <table class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th hidden>No</th>
                                                                <th>No Kontrabon</th>
                                                                <th>Tanggal</th>
                                                                <th>Perusahaan</th>
                                                                <th>Keterangan</th>
                                                                <th>Total</th>
                                                                <th>Kategori</th>
                                                                <th>Pembayaran</th>
                                                                <th>Ditujukan Kepada</th>
                                                                <th>Id User</th>
                                                                <th>Yang Mengajukan</th>
                                                                <th>Untuk Perusahaan</th>
                                                                <th>Id Vendor</th>
                                                                <th>Nama Vendor</th>
                                                                <th>Bank</th>
                                                                <th>No Rekening</th>
                                                                <th>Atas Nama</th>
                                                                <th>Nama Vendor</th>
                                                                <th>Tgl Jatuh Tempo</th>
                                                                <th>Faktur Pajak Masukan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <button type="submit" id="savedatas_barang" name="savedatas_barang" class="btn btn-success btn-sm float-right">Buat SPP</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="biaya" role="tabpanel">
                                        <div class="card-body">
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif
                                            <form id="formBiaya">
                                            @csrf
                                                <div class="table-responsive">
                                                    <div>
                                                        <table class="table table-bordered table-striped table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <input type="checkbox" id="checkAll">
                                                                    </th>
                                                                    <th>No</th>
                                                                    <th>Kode Pengajuan</th>
                                                                    <th>Tgl Pengajuan</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Keterangan</th>
                                                                    <th>Total</th>
                                                                    <th hidden>Kategori</th>
                                                                    <th hidden>Pembayaran</th>
                                                                    <th>Ditujukan Kepada</th>
                                                                    <th hidden>Id User</th>
                                                                    <th>Yang Mengajukan</th>
                                                                    <th style="min-width:200px;">Untuk Perusahaan</th>
                                                                    <!-- <th style="min-width:200px;">Metode Pembayaran</th> -->
                                                                    <th hidden>Id Vendor</th>
                                                                    <th style="min-width:200px;">Nama Vendor</th>
                                                                    <th>Bank</th>
                                                                    <th>No Rekening</th>
                                                                    <th>Atas Nama</th>
                                                                    <th>Tgl Jatuh Tempo</th>
                                                                    <th>Faktur Pajak Masukan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $no = 1; @endphp
                                                                @forelse($biaya as $val)
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" class="checkItem" name="selected_pengajuan[]" value="{{ $val->kode_pengajuan_b }}">
                                                                    </td>
                                                                    <td>{{ $no }}</td>
                                                                    <td>
                                                                        <input type="hidden" name="kode_pengajuan_b[]" id="kode_pengajuan_b" value="{{ $val->kode_pengajuan_b }}" style="border:none;"/>
                                                                        {{ $val->kode_pengajuan_b }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" name="tgl_pengajuan_b[]" id="tgl_pengajuan_b" value="{{ $val->tgl_pengajuan_b }}" style="border:none;"/>
                                                                        {{ $val->tgl_pengajuan_b }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" name="kode_perusahaan[]" id="kode_perusahaan" value="{{ $val->kode_perusahaan }}" style="border:none;"/>
                                                                        {{ $val->kode_perusahaan }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" name="keterangan[]" id="keterangan" value="{{ $val->keterangan }}" style="border:none;"/>
                                                                        {{ $val->keterangan }}
                                                                    </td>
                                                                    <td align='right'>
                                                                        <input type="hidden" name="total[]" id="total" value="{{ $val->total }}" style="border:none;"/>
                                                                        {{ number_format($val->total) }}
                                                                    </td>
                                                                    <td hidden>
                                                                        <input type="hidden" name="kategori[]" id="kategori" value="{{ $val->kategori }}" style="border:none;"/>
                                                                        {{ $val->kategori }}
                                                                    </td>
                                                                    <td hidden>
                                                                        <input type="hidden" name="pembayaran[]" id="pembayaran" value="{{ $val->pembayaran }}" style="border:none;"/>
                                                                        {{ $val->pembayaran }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" name="ditujukan[]" id="ditujukan" value="Nany Enggawati" style="border:none;"/>
                                                                        Nany Enggawati
                                                                    </td>
                                                                    <td hidden>
                                                                        <input type="hidden" name="id_user_input[]" id="id_user_input" value="{{ $val->id_user_input }}" style="border:none;"/>
                                                                        {{ $val->id_user_input }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" name="nama_user[]" id="nama_user" value="{{ $val->name }}" style="border:none;"/>
                                                                        {{ $val->name }}
                                                                    </td>
                                                                    <td style="min-width:200px;">
                                                                        <select name="kode_perusahaan_spp[]" id="kode_perusahaan_spp" class="form-control" required>
                                                                            <option value="">Select</option>
                                                                            @foreach ($perusahaan as $row)
                                                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                                                            @endforeach 
                                                                        </select>
                                                                    </td>
                                                                    <!-- <td style="min-width:200px;">
                                                                        <select name="metode_pembayaran[]" id="metode_pembayaran" class="form-control" required>
                                                                            <option value="-">Select</option>
                                                                            <option value="Tunai">Tunai</option>
                                                                            <option value="Transfer">Transfer</option>
                                                                            <option value="Cek">Cek</option> 
                                                                        </select>
                                                                    </td> -->
                                                                    <td hidden>
                                                                        <input type="text" name="kode_vendor[]" id="kode_vendor_{{ $no }}" value="" style="border:none;" readonly required/>
                                                                    </td>
                                                                    <td style="min-width:200px;">    
                                                                        <div class="input-group">
                                                                            <input id="supplier_{{ $no }}" name="supplier[]" type="text" class="form-control" value="" readonly required>
                                                                            <span class="input-group-btn">
                                                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_vendor"> <span class="fa fa-search"></span></button>
                                                                            </span>
                                                                        </div>
                                                                    </td> 
                                                                    <td>
                                                                        <input type="text" name="bank[]" id="bank_{{ $no }}" value="" style="border:none;" readonly required/>
                                                                    </td> 
                                                                    <td>
                                                                        <input type="text" name="norek[]" id="norek_{{ $no }}" value="" style="border:none;" readonly required/>
                                                                    </td> 
                                                                    <td>
                                                                        <input type="text" name="atas_nama[]" id="atas_nama_{{ $no }}" value="" style="border:none;" readonly required/>
                                                                    </td> 
                                                                    <td>
                                                                        <input type="date" name="jt[]" id="jt" value="" style="border:none;" required/>
                                                                    </td> 
                                                                    <td>
                                                                        <input type="text" name="fktur_pajak[]" id="fktur_pajak" value="0" style="border:none;" required/>
                                                                    </td> 
                                                                </tr>
                                                                <?php $no++ ?>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="19" class="text-center">Tidak ada data ditemukan</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <button type="button" id="savedatas_biaya" name="savedatas_biaya" class="btn btn-success btn-sm float-right">Buat SPP</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="sparepart" role="tabpanel">
                                        <div class="card-body">
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="#" method="get">
                                                <div class="input-group mb-3 col-md-4 float-right">  
                                                    <input type="text" id="tanggal_manual" name="tanggal_manual" class="form-control" value="{{ request()->tanggal_manual }}">
                                                    &nbsp
                                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                                </div>    
                                            </form>

                                            <div class="table-responsive">
                                                <!-- <table class="table table-hover table-bordered"> -->
                                                <div style="width:100%;">
                                                    <table class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th hidden>No</th>
                                                                <th>No SPP</th>
                                                                <th>Tgl SPP</th>
                                                                <th>Perusahaan</th>
                                                                <th>Keterangan</th>
                                                                <th>Total</th>
                                                                <th>Kategori</th>
                                                                <th>Pembayaran</th>
                                                                <th>Ditujukan Kepada</th>
                                                                <th>Id User</th>
                                                                <th>Yang Mengajukan</th>
                                                                <th>Untuk Perusahaan</th>
                                                                <th>Id Vendor</th>
                                                                <th>Nama Vendor</th>
                                                                <th>Bank</th>
                                                                <th>No Rekening</th>
                                                                <th>Atas Nama</th>
                                                                <th>Nama Vendor</th>
                                                                <th>Tgl Jatuh Tempo</th>
                                                                <th>Faktur Pajak Masukan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($sparepart as $val)
                                                                
                                                            @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <button type="submit" id="savedatas_sparepart" name="savedatas_sparepart" class="btn btn-success btn-sm float-right">Buat SPP</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="fleet" role="tabpanel">
                                        <div class="card-body">
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="#" method="get">
                                                <div class="input-group mb-3 col-md-4 float-right">  
                                                    <input type="text" id="tanggal_manual" name="tanggal_manual" class="form-control" value="{{ request()->tanggal_manual }}">
                                                    &nbsp
                                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                                </div>    
                                            </form>

                                            <div class="table-responsive">
                                                <!-- <table class="table table-hover table-bordered"> -->
                                                <div style="width:100%;">
                                                    <table class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th hidden>No</th>
                                                                <th>Tgl Pengajuan</th>
                                                                <th>Keterangan</th>
                                                                <th>No SPP</th>
                                                                <th>Tgl SPP</th>
                                                                <th>Nilai SPP</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <button type="submit" id="savedatas_fleet" name="savedatas_fleet" class="btn btn-success btn-sm float-right">Buat SPP</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal_vendor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_vendor" id="cari_vendor" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_vendor" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Vendor Id</th>
                                <th>Vendor Name</th>
                                <th>Address</th>
                                <th>Bank</th>
                                <th>No Rek</th>
                                <th hidden>Atas Nama</th>
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

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        
        $(document).ready(function() {
           
            //INISIASI DATERANGEPICKER
            $('#tanggal').daterangepicker({
               
            })
 
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            fetch_data_vendor();
            function fetch_data_vendor(query = '')
            {
                $.ajax({
                    url:'{{ route("spp_group/action_vendor.actionVendor") }}',
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#lookup_vendor tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#cari_vendor', function(){
                var query = $(this).val();
                fetch_data_vendor(query);
            });
        });

        baris = 1;
        $(document).on('click', '.pilih_vendor', function (e) {
            document.getElementById('kode_vendor_'+baris+'').value = $(this).attr('data-kodevendor');
            document.getElementById('supplier_'+baris+'').value = $(this).attr('data-namavendor');
            document.getElementById('atas_nama_'+baris+'').value = $(this).attr('data-atasnama');
            document.getElementById('bank_'+baris+'').value = $(this).attr('data-namabank');
            document.getElementById('norek_'+baris+'').value = $(this).attr('data-norek');

            $('#myModal_vendor').modal('hide');

            baris++;
        });

        //Simpan SPP Biaya
        $(document).ready(function(){
            $("#savedatas_biaya").click(function(e){
                e.preventDefault();

                if(confirm("Apakah Anda yakin ingin menyimpan data ini?")){

                    $.ajax({
                        url: "{{ route('spp_group/store.store') }}", // route tujuan simpan
                        type: "POST",
                        data: $("#formBiaya").serialize(), // ambil semua input dari form
                        success: function(response){
                            // tampilkan notifikasi sukses
                            
                            window.open("spp_group/pdf/" + response.no_group, "_blank");   
                            // optional: reload page / kosongkan form
                            // location.reload();
                        },
                        error: function(xhr){
                            let msg = 'Gagal menyimpan data';
                            if(xhr.responseJSON && xhr.responseJSON.message){
                                msg = xhr.responseJSON.message;
                            }
                            $("#alertContainer").html(`
                                <div class="alert alert-danger">${msg}</div>
                            `);
                        }
                    });
                }
            });
        });

        // ceklis semua
        $("#checkAll").on('click', function() {
            $(".checkItem").prop('checked', $(this).prop('checked'));
        });

        // kalau salah satu checkbox diubah, update status header
        $(".checkItem").on('click', function() {
            if ($(".checkItem:checked").length === $(".checkItem").length) {
                $("#checkAll").prop("checked", true);
            } else {
                $("#checkAll").prop("checked", false);
            }
        });

    </script>
@endsection