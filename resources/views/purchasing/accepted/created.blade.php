@section('js')
<script type="text/javascript">

    // $(document).on('click', '.pilih_coa', function(e) {
    //     document.getElementById('kode_coa').value = $(this).attr('data-kode_coa')
    //     document.getElementById('coa').value = $(this).attr('data-coa')
    //     document.getElementById('debit').value = $(this).attr('data-debit')
    //     document.getElementById('kredit').value = $(this).attr('data-kredit')


    //     $('#myModalCoa').modal('hide');
    // });

    $(document).on('click', '.pilih_category', function(e){
        document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
        document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
        document.getElementById('sifat').value = $(this).attr('data-sifat')
        document.getElementById('jenis').value = $(this).attr('data-jenis')
        document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')

        document.getElementById('kode_coa').value = $(this).attr('data-coa')
        document.getElementById('nama_coa').value = $(this).attr('data-nama_coa')
        document.getElementById('debet').value = $(this).attr('data-debit')
        document.getElementById('kredit').value = $(this).attr('data-kredit')
        
        $('#myModalKategori').modal('hide');
    });
    
    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("accepted/create/store.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    // $(document).ready(function(){
    //     fetch_vendor_data();
    //     function fetch_vendor_data(query = '')
    //     {
    //         $.ajax({
    //             url:'{{ route("accepted/action_coa.actionCoa") }}',
    //             method:'GET',
    //             data:{query:query},
    //             dataType:'json',
    //             success:function(data)
    //             {
    //                 $('#lookup_coa tbody').html(data.table_data);
    //             }
    //         })
    //     }

    //     $(document).on('keyup', '#search_coa', function(){
    //         var query = $(this).val();
    //         fetch_vendor_data(query);
    //     });
    // });

    $(document).ready(function(){
        fetch_data_category();
        function fetch_data_category(query = '')
        {
            $.ajax({
                url:'{{ route("accepted/action_category.actionCategory") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_category tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_category', function(){
            var query = $(this).val();
            fetch_data_category(query);
        });
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Buat Kontrabon</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Acepted</li>
        <li class="breadcrumb-item active">Buat Kontrabon</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('accepted/create/store.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Buat Kontrabon</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        No Kontrabon
                                        <input type="text" name="no_kb" class="form-control" value="{{ $no_kb }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Termin
                                        <input type="text" name="termin" class="form-control" value="">
                                        
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Tanggal
                                        <input type="text" name="tgl_kb" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-1 mb-2 float-right">

                                    </div>

                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2 float-right">
                                        Vendor
                                        <div class="input-group">
                                            <input id="supplier" type="text" name="supplier" value="{{ $kontrabon->nama_vendor }}" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ $kontrabon->kode_vendor }}" required readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-1 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Jatuh Tempo
                                        <input id="jatuh_tempo" type="date" class="form-control" name="jatuh_tempo" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                     
                                    </div>

                                    <div class="col-md-1 mb-2 float-right">

                                    </div>

                                    @if($kontrabon->ket_transaksi == 'Barang Dagang')
                                        
                                        <div class="col-md-4 mb-2">
                                            Nama Pengeluaran
                                            <div class="input-group">
                                                <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" value="" required >
                                                <input id="nama_pengeluaran" type="text" class="form-control" readonly required>
                                                <input id="sifat" type="hidden" name="sifat" class="form-control"  required>
                                                <input id="jenis" type="hidden" name="jenis" class="form-control"  required>
                                                <input id="pembayaran" type="hidden" name="pembayaran" class="form-control"  required>
                                                <input id="kategori" type="hidden" name="kategori" class="form-control"  required>
                                                <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran" class="form-control"  required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                            <!-- Object COA -->
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="kode_coa" type="text" name="kode_coa" class="form-control" required>
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="nama_coa" type="text" name="nama_coa" class="form-control" required>
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="debet" type="text" name="debet" class="form-control" required>
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="kredit" type="text" name="kredit" class="form-control" required>
                                            </div>
                                            <!-- End Object COA -->
                                        </div>
                                    @else
                                        <div class="col-md-3 mb-2">
                                            {{-- <!-- Object COA -->
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="id_pengeluaran" type="text" name="id_pengeluaran" value="{{ $kontrabon_coa->jenis }}" required >
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="nama_pengeluaran" type="text" value="{{ $kontrabon_coa->nama_pengeluaran }}" readonly required>
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="kode_coa" type="text" name="kode_coa" class="form-control" value="{{ $kontrabon_coa->coa }}"  required>
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="nama_coa" type="text" name="nama_coa" class="form-control" value="{{ $kontrabon_coa->nama_transaksi }}"  required>
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="debet" type="text" name="debet" class="form-control" value="{{ $kontrabon_coa->debet_1 }}" required>
                                            </div>
                                            <div class="col-md-4 mb-2" hidden>
                                                <input id="kredit" type="text" name="kredit" class="form-control" value="{{ $kontrabon_coa->kredit_1 }}" required>
                                            </div>
                                            <!-- End Object COA --> --}}
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    
                                    <div class="col-md-4 mb-2" >
                                        Total
                                        <input style="text-align: right;" type="text" name="total_head" class="form-control" value="{{ number_format($kontrabon->total) }}" required readonly>
                                    </div>
                                    <div class="col-md-1 mb-2" >
                                        
                                    </div>
                                    <div class="col-md-6 mb-2" >
                                        Keterangan
                                        <input type="text" name="description" class="form-control" value="" required>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <form id="savedatas">
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;font-size: 13px;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>No BTB</th>
                                                    <th>Dokumen Vendor</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Sub Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($kontrabon_detail as $val)
                                                <tr>
                                                    <td hidden>
                                                        <input type="text" class="form-control" name="no_btb[]" id="no_btb_" style="font-size: 13px;" value="{{ $val->no_btb }}" readonly hidden>
                                                        {{ $val->no_btb }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="no_faktur[]" id="no_faktur_" style="font-size: 13px;" value="{{ $val->no_faktur }}" readonly hidden>
                                                        {{ $val->no_faktur }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="tanggal[]" id="tanggal_" style="font-size: 13px;" value="{{ $val->tgl_faktur }}" readonly hidden>
                                                        {{ $val->tgl_faktur }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="total[]" id="total_" style="font-size: 13px;text-align: right;" value="{{ number_format($val->total) }}" readonly hidden>
                                                        {{ number_format($val->total) }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="sub_total[]" id="sub_total_" style="font-size: 13px;text-align: right;" value="{{ number_format($val->total) }}" readonly hidden>
                                                        {{ number_format($val->total) }}
                                                    </td>
                                                    <td align="center">
                                                        <a href="{{ route('accepted/create/view_invoice.view_detail', $val->no_faktur) }}" class="btn btn-primary btn-sm">View</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>    
                                
                              
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Buat Kontrabon</button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_category" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Pengeluaran</th>
                                <th>Sifat</th>
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

<!-- <div class="modal fade bd-example-modal-lg" id="myModalCoa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" hidden>
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa" id="search_coa" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_coa" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Account Id</th>
                                <th>Account Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->


@endsection




