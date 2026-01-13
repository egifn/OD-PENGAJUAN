@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Detail Pengajuan Barang</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">Detail Pengajuan Barang</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Pengajuan Barang - {{ $pengajuan_v->kode_pengajuan }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2" hidden>
                                        Id Pengajuan
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
                                    <div class="col-md-4 mb-2">
                                        Perusahaan
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $pengajuan_v->nama_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="nama_depo" class="form-control" value="{{ $pengajuan_v->nama_depo }}" readonly>
                                    </div>
                                </div>

                                <div class="row" >    
                                    <div class="col-md-4 mb-2" hidden>
                                        Kategori Pengeluaran
                                        <input type="text" name="kategori_pengeluaran" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2" hidden>
                                        Keterangan
                                        <input type="text" name="ket" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Pengajuan
                                        <input type="text" name="pengajuan" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_v->nama_pengeluaran }}" readonly>
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
                                    <div style="border:1px white;width:100%;height:150px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Id Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th hidden>Merk</th>
                                                    <th>Spek</th>
                                                    <th>Kategori Barang</th>
                                                    <th>Qty</th>
                                                    <th>Acc IT</th>
                                                    <th>Acc Ops</th>
                                                    <th>Acc GA</th>
                                                    <th>Acc Prc</th>
                                                    <th>Divisi</th>
                                                    <th>Keterangan/desc</th>
                                                    <th hidden>File/attach</th>
                                                    <th>Ceklist</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($details as $row)
                                            <tr>
                                                <td hidden>#</td>
                                                <td>{{ $row->kode_product }}</td>
                                                @if(Auth::user()->kode_divisi == '27')
                                                @if($pengajuan_v->kode_jenis == '26')
                                                        <td>{{ $row->nama_produk }}</td>
                                                        <td hidden>-</td>
                                                        <td>-</td>
                                                    @else
                                                        <td>{{ $row->nama_barang }}</td>
                                                        <td hidden>{{ $row->merk }}</td>
                                                        <td>{{ $row->ket }}</td>
                                                    @endif
                                                @else
                                                    <td>{{ $row->nama_barang }}</td>
                                                    <td hidden>{{ $row->merk }}</td>
                                                    <td>{{ $row->ket }}</td>
                                                @endif
                                                <td>{{ $row->name }}</td>
                                                <td align="right">{{ $row->qty }}</td>
                                                <td align="right">{{ $row->qty_it }}</td>
                                                <td align="right">{{ $row->qty_ops }}</td>
                                                <td align="right">{{ $row->qty_ga }}</td>
                                                <td align="right">{{ $row->qty_pc }}</td>
                                                <td>{{ $row->nama_divisi }}</td>
                                                <td>{{ $row->description }}</td>
                                                <td hidden>
                                                    <!-- <a href="{{url('images/pengajuan/'. $row->image)}}" >
                                                        {{ $row->image }}
                                                    </a> -->

                                                    <a href="#" data-toggle="modal" data-target="#modal_image{{ $row->kode_product }}">
                                                        {{ $row->image }}
                                                    </a>

                                                    <div class="modal fade" id="modal_image{{ $row->kode_product }}" tabindex="-1" role="dialog" aria-labelledby="modal_image" aria-hidden="true">
                                                      <div class="modal-dialog" style="max-width: 55%; max-height: 55%;" role="document">                               
                                                        <div class="modal-content">                                       
                                                         <div class="modal-body">
                                                                                             
                                                           <button type="button" class="close" data-dismiss="modal"><span 
                                                           aria-hidden="true">&times;</span><span class="sr- 
                                                           only"> Tutup</span></button>                              
                                                           <img src="{{url('images/pengajuan/'. $row->image)}}" class="imagepreview" style="width: 100%;">
                                                                                          
                                                         </div>                             
                                                       </div>                                  
                                                      </div>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    @if($row->status_cek_atasan == '0') <!-- Baru -->
                                                        <input type="checkbox" name="chk" id="chk" value="1" disabled/>
                                                    @elseif($row->status_cek_atasan == '1') <!-- Approved -->
                                                        <input type="checkbox" name="chk" id="chk" value="1" checked disabled/> <!--  -->
                                                    @elseif($row->status_cek_atasan == '2') <!-- denied -->
                                                        <input type="checkbox" name="chk" id="chk" value="1" disabled/>
                                                    @elseif($row->status_cek_atasan == '3') <!-- pending -->
                                                        <input type="checkbox" name="chk" id="chk" value="1" disabled/>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#modalKet{{ $row->kode_product }}">Detail Keterangan</a>
                                                </td>
                                            </tr>

                                            <!-- Modal Keterangan -->
                                            <div class="modal fade bd-example-modal-lg" id="modalKet{{ $row->kode_product }}" tabindex="-1" aria-labelledby="modalKet" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="#" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <b>{{ $row->kode_pengajuan }}</b>
                                                                    <br>
                                                                    <br>
                                                                    <label for="">keterangan Pengaju:</label>
                                                                    
                                                                    <div class="row">
                            
                                                                        <div class="col-md-4 mb-2">
                                                                            <input type="text" name="tgl" class="form-control" value="{{ $row->nama_barang }}" readonly>
                                                                        </div>
                                                                        <div class="col-md-8 mb-2">
                                                                            <input type="text" name="nama_pemohon" class="form-control" value="{{ $row->description }}" readonly>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    

                                                                    <label for="">keterangan Atasan:</label>
                                                                    
                                                                    <div class="row">
                            
                                                                        <div class="col-md-4 mb-2">
                                                                            <input type="text" name="tgl" class="form-control" value="{{ $row->nama_barang }}" readonly>
                                                                        </div>
                                                                        <div class="col-md-8 mb-2">
                                                                            <input type="text" name="nama_pemohon" class="form-control" value="{{ $row->keterangan_detail_atasan }}" readonly>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    

                                                                    <label for="">keterangan IT:</label>
                                                                    
                                                                    <div class="row">
                            
                                                                        <div class="col-md-4 mb-2">
                                                                            <input type="text" name="tgl" class="form-control" value="{{ $row->nama_barang }}" readonly>
                                                                        </div>
                                                                        <div class="col-md-8 mb-2">
                                                                            <input type="text" name="nama_pemohon" class="form-control" value="{{ $row->keterangan_detail_adm_it }}" readonly>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    

                                                                    <label for="">Keterangan Operasional:</label>
                                                                    
                                                                    <div class="row">
                            
                                                                        <div class="col-md-4 mb-2">
                                                                            <input type="text" name="tgl" class="form-control" value="{{ $row->nama_barang }}" readonly>
                                                                        </div>
                                                                        <div class="col-md-8 mb-2">
                                                                            <input type="text" name="nama_pemohon" class="form-control" value="{{ $row->keterangan_detail_adm_ops }}" readonly>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    

                                                                    <label for="">Keterangan General Affair:</label>
                                                                    
                                                                    <div class="row">
                            
                                                                        <div class="col-md-4 mb-2">
                                                                            <input type="text" name="tgl" class="form-control" value="{{ $row->nama_barang }}" readonly>
                                                                        </div>
                                                                        <div class="col-md-8 mb-2">
                                                                            <input type="text" name="nama_pemohon" class="form-control" value="{{ $row->keterangan_detail_adm_ga }}" readonly>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    

                                                                    <label for="">keterangan Purchasing:</label>
                                                                    
                                                                    <div class="row">
                            
                                                                        <div class="col-md-4 mb-2">
                                                                            <input type="text" name="tgl" class="form-control" value="{{ $row->nama_barang }}" readonly>
                                                                        </div>
                                                                        <div class="col-md-8 mb-2">
                                                                            <input type="text" name="nama_pemohon" class="form-control" value="{{ $row->keterangan_detail_adm_pc }}" readonly>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal Keterangan -->
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
                                    <div class="col-md-12 mb-2">
                                        <div class="input-group mb-3">
                                            
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($pengajuan_upload as $row)
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
                                                    
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>
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


