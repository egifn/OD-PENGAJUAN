@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Approval Detail</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item active">Approval Detail</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Approval</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Request Id
                                        <input type="text" name="kode" class="form-control" value="{{ $pengajuan_v->kode_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Request By
                                        <input type="text" name="nama_pemohon" class="form-control" value="{{ $pengajuan_v->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Perusahaan
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $pengajuan_v->nama_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="nama_depo" class="form-control" value="{{ $pengajuan_v->nama_depo }}" readonly>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Request
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_v->tgl_pengajuan }}" readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_v->nama_pengeluaran }}" readonly>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2">
                                        Tipe
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_v->sifat }}" readonly>
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
                                                    <th hidden>Tipe Id</th>
                                                    <th>Kategori</th>
                                                    <th>Id Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Desc/Spek</th>
                                                    <th>Tipe</th>
                                                    <th>Qty</th>
                                                    <th>Satuan</th>
                                                    <th>Divisi</th>
                                                    <th hidden>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=0; ?>
                                            @forelse ($details as $row)
                                            <tr>
                                                <td hidden>
                                                    <input class="form-control" type="text" name="typeid[]" id="typeid_" value="{{ $row->id }}" readonly hidden/>{{ $row->id }}
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="type[]" id="type_" value="{{ $row->name }}" readonly hidden/>{{ $row->name }}
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="kode_produk[]" id="kode_produk_" value="{{ $row->kode_product }}" readonly hidden/>{{ $row->kode_product }}
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="nama_produk[]" id="nama_produk_<?php echo $i; ?>" value="{{ $row->nama_barang }}" readonly hidden/>{{ $row->nama_barang }}
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="merk[]" id="merk_<?php echo $i; ?>" value="{{ $row->merk }}" readonly hidden/>{{ $row->merk }}
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="ket[]" id="ket_<?php echo $i; ?>" value="{{ $row->ket }}" readonly hidden/>{{ $row->ket }}
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="kategori[]" id="kategori_<?php echo $i; ?>" value="{{ $row->name }}" readonly hidden/>{{ $row->name }}
                                                </td>
                                                <td>
                                                    <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty_<?php echo $i; ?>" value="{{ $row->qty_pc }}" readonly hidden/>{{ $row->qty_pc }}
                                                </td>
                                                <td>
                                                    <input style="text-align: right" class="form-control" type="text" name="satuan[]" id="satuan_<?php echo $i; ?>" value="{{ $row->satuan }}" readonly hidden/>{{ $row->satuan }}
                                                </td>
                                                <td>
                                                    <input style="text-align: right" class="form-control" type="text" name="divisi[]" id="divisi_<?php echo $i; ?>" value="{{ $row->nama_divisi }}" readonly hidden/>{{ $row->nama_divisi }}
                                                </td>
                                                <td hidden>
                                                    @if($row->status_cek_bod == '0')
                                                        <input name="chk[]" id="chk_<?php echo $i; ?>" type="checkbox" unchecked />
                                                    @elseif($row->status_cek_bod == '1')
                                                        <input name="chk[]" id="chk_<?php echo $i; ?>" type="checkbox" checked />
                                                    @endif
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
                                    @if($pengajuan_v->status_pengajuan  == '1') <!-- 6: approved -->
                                       
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_pengajuan  == '2') <!-- 3: denied -->
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_pengajuan == '3') <!-- 4: Pending -->
                                        
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('approval-bod-update', $pengajuan_v->no_urut) }}" class="btn btn-success btn-sm">Approved</a>

                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('approval-bod-denied', $pengajuan_v->no_urut) }}" class="btn btn-danger btn-sm">Denied</a>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('approval-bod-pending', $pengajuan_v->no_urut) }}" class="btn btn-warning btn-sm">Pending</a>
                                        </div>
                                    @else
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('approval-bod-update', $pengajuan_v->no_urut) }}" class="btn btn-success btn-sm">Approved</a>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('approval-bod-denied', $pengajuan_v->no_urut) }}" class="btn btn-danger btn-sm">Denied</a>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('approval-bod-pending', $pengajuan_v->no_urut) }}" class="btn btn-warning btn-sm">Pending</a>
                                        </div>
                                    @endif
                                    

                                    <div class="col-md-9 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
                                    </div> 
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


