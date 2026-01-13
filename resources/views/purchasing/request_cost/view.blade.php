@section('js')


<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>View Request</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purch & Payment</li>
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item">Cost Request</li>
        <li class="breadcrumb-item active">View Request</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Request [ID: {{ $pengajuan_biaya_h->kode_pengajuan_b }} ]</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Request
                                        <input type="text" name="tgl" class="form-control" value=" {{ $pengajuan_biaya_h->tgl_pengajuan_b }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Request By
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_biaya_h->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" class="form-control" value="{{ $pengajuan_biaya_h->nama_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="kode_depo" class="form-control" value="{{ $pengajuan_biaya_h->nama_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Divisi
                                        <input type="text" name="kode_divisi" class="form-control" value="{{ $pengajuan_biaya_h->nama_divisi }}" required readonly>
                                       
                                    </div>

                                </div>
                               
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="kategori" class="form-control" value="{{ $pengajuan_biaya_h->nama_pengeluaran }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-7 mb-2">
                                        Keterangan
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_biaya_h->keterangan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" class="form-control" value="{{ $pengajuan_biaya_h->no_urut }}" required>
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
                                                    <th>Uraian</th>
                                                    <th>Spesifikasi</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga</th>
                                                    <th>Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=0; ?>
                                            @forelse ($pengajuan_biaya_d as $row)
                                            <tr>
                                                <td hidden>#</td>
                                                <td>
                                                    {{ $row->description }}
                                                </td>
                                                <td>
                                                    {{ $row->spesifikasi }}
                                                </td>
                                                <td align="right">
                                                    {{ number_format($row->qty) }}
                                                </td>
                                                <td align="right">
                                                    {{ number_format($row->harga) }}
                                                </td>
                                                <td align="right">
                                                    {{ number_format($row->tharga) }}
                                                </td>
                                            <?php
                                                $i++; 
                                            ?>
                                            </tr>
                                            @empty

                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-10 mb-2">
                                        <label for="total" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ number_format($pengajuan_biaya_detail_total) }}" style="text-align:right; font-style:bold;" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    @if($pengajuan_biaya_h->status  == '6') 
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('request_cost-pay', $pengajuan_biaya_h->no_urut) }}" class="btn btn-success btn-sm">Pembayaran</a>
                                        </div>
                                        <!--
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('request_cost-denied', $pengajuan_biaya_h->no_urut) }}" class="btn btn-danger btn-sm" disabled>Denied</a>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <a href="{{ route('request_cost-pending', $pengajuan_biaya_h->no_urut) }}" class="btn btn-warning btn-sm" disabled>Pending</a>
                                        </div>
                                        -->
                                     @elseif($pengajuan_biaya_h->status == '5')
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Pembayaran</button>
                                        </div>
                                        <!--
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                        -->
                                    @elseif($pengajuan_biaya_h->status == '2')
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Pembayaran</button>
                                        </div>
                                        <!--
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                        -->
                                    @elseif($pengajuan_biaya_h->status == '3')
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Pembayaran</button>
                                        </div>
                                        <!--
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                         -->
                                    @elseif($pengajuan_biaya_h->status == '0')
                                        @if($pengajuan_biaya_h->kode_kategori == '33' or $pengajuan_biaya_h->kode_kategori == '9' or $pengajuan_biaya_h->kode_kategori == '12' or $pengajuan_biaya_h->kode_kategori == '21' or $pengajuan_biaya_h->kode_kategori == '17' or $pengajuan_biaya_h->kode_kategori == '18') <!-- jika dibuatkan Pengajuan SPP oleh Purchasing -->
                                            <div class="col-md-1 mb-2">
                                                <a href="{{ route('request_cost-pay', $pengajuan_biaya_h->no_urut) }}" class="btn btn-success btn-sm">Pembayaran</a>
                                            </div>    
                                        @else <!-- jika Tidak -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Pembayaran</button>
                                            </div> 
                                        @endif 
                                    @else

                                         <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Pembayaran</button>
                                        </div>
                                        
                                        <!--
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                         -->
                                    @endif
                                   
                                    <div class="col-md-11 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
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




