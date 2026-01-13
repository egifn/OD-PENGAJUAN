@section('js')
    <script type="text/javascript">
        $('#updatedatas').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '#',
                type: 'POST',
                data: $(this).serializeArray(),
                success: function(data){
                    console.log(data);
                }
            });
        });

        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Request Detail</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Daftar Pengajuan</li>
        <li class="breadcrumb-item">Daftar Pengajuan Barang</li>
        <li class="breadcrumb-item active">Detail Pengajuan Barang</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Pengajuan Barang - [{{ $pengajuan_v->kode_pengajuan }}]</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2" hidden>
                                        Request Id
                                        <input type="text" name="kode" class="form-control" value="{{ $pengajuan_v->kode_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_v->tgl_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama_pemohon" class="form-control" value="{{ $pengajuan_v->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $pengajuan_v->nama_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="nama_depo" class="form-control" value="{{ $pengajuan_v->nama_depo }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Keterangan
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_v->keterangan }}" readonly>
                                        
                                    </div>
                                </div>
                               
                                
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_v->nama_pengeluaran }}" readonly>
                                        
                                    </div>
                                    
                                    <div class="col-md-4 mb-2" hidden>
                                        Kategori Pengeluaran
                                        <input type="text" name="kategori_pengeluaran" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Sifat Pengeluaran
                                        <input type="text" name="sifat_pengeluaran" class="form-control" value="{{ $pengajuan_v->sifat }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jenis Pengeluaran
                                        <input type="text" name="jenis_pengeluaran" class="form-control" value="{{ $pengajuan_v->jenis }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Sistem Pembayaran
                                        <input type="text" name="sistem_pengeluaran" class="form-control" value="{{ $pengajuan_v->pembayaran }}" readonly>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    
                
                    <div class="col-md-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:180px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Produk Id</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Desc/Spek</th>
                                                    <th>Ktgri</th>
                                                    <th>Qty</th>
                                                    <th>Stok</th>
                                                    <th>Divisi</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=0; ?>
                                            @forelse ($details as $row)
                                            <tr>
                                                <td hidden>#</td>
                                                <td>
                                                    <!--
                                                    <input class="form-control" type="text" name="kode_produk[]" id="kode_produk_<?php //echo $i; ?>" value="{{ $row->kode_product }}" readonly />
                                                    -->
                                                    {{ $row->kode_product }}
                                                </td>
                                                <td>
                                                    <!--
                                                    <input class="form-control" type="text" name="nama_produk[]" id="nama_produk_<?php //echo $i; ?>" value="{{ $row->nama_barang }}" readonly />
                                                    -->
                                                    {{ $row->nama_barang }}
                                                </td>
                                                <td>
                                                    <!--
                                                    <input class="form-control" type="text" name="merk[]" id="merk_<?php //echo $i; ?>" value="{{ $row->merk }}" readonly />
                                                    -->
                                                    {{ $row->merk }}
                                                </td>
                                                <td>
                                                    <!--
                                                    <input class="form-control" type="text" name="ket[]" id="ket_<?php //echo $i; ?>" value="{{ $row->ket }}" readonly />
                                                    -->
                                                    {{ $row->ket }}
                                                </td>
                                                <td>
                                                    <!--
                                                    <input class="form-control" type="text" name="kategori[]" id="kategori_<?php //echo $i; ?>" value="{{ $row->name }}" readonly />
                                                    -->
                                                    {{ $row->name }}
                                                </td>
                                                <td>
                                                    <!--
                                                    <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty_<?php //echo $i; ?>" value="{{ $row->qty }}" readonly />
                                                    -->
                                                    {{ $row->qty_pc }}
                                                </td>
                                                <td>
                                                    {{ $row->stock }}
                                                </td>
                                                <td>
                                                    <!--
                                                    <input class="form-control" type="text" name="divisi[]" id="divisi_<?php //echo $i; ?>" value="{{ $row->nama_divisi }}" readonly />
                                                    -->
                                                    {{ $row->nama_divisi }}
                                                </td>
                                                

                                                <?php
                                                    $i++;
                                                ?>
                                            </tr>
                                            @empty
                                            <tr>
                                                
                                            </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    &ensp;&ensp;
                                    <div class="col-mb-2">
                             
                                        @if( $pengajuan_v->status_pengajuan == '1' )
                                            <a href="{{ route('create_order.create', $pengajuan_v->no_urut) }}" class="btn btn-success btn-sm">Buat PO</a>
                                        @endif
                                        
                                    </div>
                                    &ensp;
                                    <div class="col-mb-2">
                                        <!--
                                        <a href="{{ route('approval-denied', $pengajuan_v->kode_pengajuan) }}" class="btn btn-danger btn-sm">Denied</a>
                                        -->
                                    </div>
                                    &ensp;
                                    <div class="col-mb-2">
                                        <!--
                                        <button type="submit" class="btn btn-warning btn-sm">Pending</button>
                                        -->
                                    </div>

                                    @if( $pengajuan_v->status_pengajuan == '1' )
                                        <div class="col-md-11 mb-2">
                                            <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                        </div> 
                                    @endif

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            
        </div>
    </div>
</main>

@endsection

@section('script')



@endsection


