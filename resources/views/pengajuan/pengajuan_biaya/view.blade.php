@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".chk");
            const totalHargaInput = document.getElementById("total_harga");

            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const row = cb.closest("tr");
                    const price = parseFloat(row.querySelector(".total-price").dataset.value);
                    total += price;
                }
            });

            totalHargaInput.value = total.toLocaleString("id-ID"); 
        });

    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Pengajuan Biaya/Jasa</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Pengajuan Biaya/Jasa</li>
        <li class="breadcrumb-item active">Detail Pengajuan Biaya/Jasa</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Pengajuan Biaya/Jasa - {{ $pengajuan_biaya_head->kode_pengajuan_b }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_biaya_head->tgl_pengajuan_b }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama_pemohon" class="form-control" value="{{ $pengajuan_biaya_head->name }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Company Name
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $pengajuan_biaya_head->nama_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="nama_depo" class="form-control" value="{{ $pengajuan_biaya_head->nama_depo }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        <label for="jenis">Division</label>
                                        <input type="text" name="divisi" class="form-control" value="{{ $pengajuan_biaya_head->nama_divisi }}" readonly>
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="divisi" class="form-control" value="{{ $pengajuan_biaya_head->keterangan_pengajuan }}" readonly>
                                    </div>
                                    
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_biaya_head->nama_pengeluaran }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Keterangan
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_biaya_head->keterangan_pengeluaran }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Sifat Pengeluaran
                                        <input type="text" name="sifat_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->sifat }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jenis Pengeluaran
                                        <input type="text" name="jenis_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->jenis }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Sistem Pembayaran
                                        <input type="text" name="sistem_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->pembayaran }}" readonly>
                                    </div>
                                    
                                    
                                </div>
                                
                               
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Description</th>
                                                    <th>Spesification</th>
                                                    @if($pengajuan_biaya_head->kategori == '1'|| $pengajuan_biaya_head->kategori == '2' || $pengajuan_biaya_head->kategori == '3' || $pengajuan_biaya_head->kategori == '4' || $pengajuan_biaya_head->kategori == '5' )
                                                        <th>Jml Karyawan</th>
                                                    @else
                                                        <th>Qty</th>
                                                    @endif
                                                    <th>Price</th>
                                                    <th>Total Price</th>
                                                    <th>Ceklist</th>
                                                    <th>Keterangan</th>
                                                    <!-- <th width="50px">Lampiran/Attachment</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($pengajuan_biaya_detail as $row)
                                                <tr>
                                                    <td hidden>#</td>
                                                    <td>{{ $row->description}}</td>
                                                    <td>{{ $row->spesifikasi}}</td>
                                                    <td align="right">{{ $row->qty }}</td>
                                                    <td align="right">{{ number_format($row->harga)}}</td>
                                                    <td align="right" class="total-price" data-value="{{ $row->tharga }}">
                                                        {{ number_format($row->tharga) }}
                                                    </td>
                                                    <td align="center">
                                                        @if($row->status_detail == '0' and $row->status_detail_atasan == '0') <!-- Baru -->
                                                            <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/>
                                                        @elseif($row->status_detail == '1' and $row->status_detail_atasan == '0') <!-- Approved -->
                                                           <input type="checkbox" class="chk" name="chk" id="chk" value="1" checked disabled/> <!--  -->
                                                        @elseif($row->status_detail == '1' and $row->status_detail_atasan == '1' and $row->status_detail_acc == '0') <!-- Approved -->
                                                           <input type="checkbox" class="chk" name="chk" id="chk" value="1" checked disabled/> 
                                                        @elseif($row->status_detail == '1' and $row->status_detail_atasan == '1' and $row->status_detail_acc == '1') <!-- Approved -->
                                                           <input type="checkbox" class="chk" name="chk" id="chk" value="1" checked disabled/> 
                                                        @elseif($row->status_detail == '1' and $row->status_detail_atasan == '1' and $row->status_detail_acc == '3')
                                                            <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/> 
                                                        @elseif($row->status_detail == '1' and $row->status_detail_atasan == '2') <!-- Approved -->
                                                           <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/> <!--  -->
                                                        @elseif($row->status_detail == '1' and $row->status_detail_atasan == '3') <!-- Approved -->
                                                           <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/> <!--  -->

                                                        @elseif($row->status_detail == '2') <!-- denied -->
                                                            <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/>
                                                        @elseif($row->status_detail == '3') <!-- pending -->
                                                            <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/>
                                                        @endif
 
                                                    </td>
                                                    <td>
                                                        @if($row->status_detail == '3')
                                                            <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" required readonly>
                                                        @elseif($row->status_detail_atasan == '3')
                                                            <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_atasan }}" required readonly>
                                                        @elseif($row->status_detail_acc == '3')
                                                            <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" required readonly>
                                                        @elseif($row->status_detail_acc == '2')
                                                            <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" required readonly>
                                                        @else
                                                            <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_atasan }}" required readonly> 
                                                        @endif
                                                        <!-- <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" required readonly> -->
                                                        <!-- <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_atasan }}" required readonly> -->
                                                    </td>
                                                    <!-- <td align="right">
                                                        {{ $row->jml_file }} 
                                                        <a href="#" data-toggle="modal" data-target="#modal"> (Lihat File)</a>
                                                    </td> -->
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
                                      
                                    <div class="col-md-8 mb-2">
                                        <div class="input-group mb-3">
                                            
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($pengajuan_biaya_upload as $row)
                                                    <tr>
                                                        <td><i>Attachment_{{ $no }}</i></td>
                                                        <td>
                                                            <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                {{ $row->filename }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center">Tidak file yang di lampirkan</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label for="total" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="0" style="text-align:right; font-style:bold;" required readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
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


