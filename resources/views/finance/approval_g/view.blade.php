@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        $('#savedatas').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("approval_g-approved") }}',
                type: 'post',
                data: $(this).serializeArray(),
                success: function(data){
                    console.log(data);
                }
            });
        });
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>View Approval Permission G</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
         @if(Auth::user()->kode_divisi == '14') <!-- Jika user login BOD, kode divisi 14 -->
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Approval Izin</li>
            <li class="breadcrumb-item">Izin F</li>
            <li class="breadcrumb-item active">View Izin F</li>
        @else
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Finance</li>
            <li class="breadcrumb-item">Approval</li>
            <li class="breadcrumb-item">Approval F</li>
            <li class="breadcrumb-item active">View Approval Permission F</li>
        @endif
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <form action="{{ route('approval_g-approved') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Approval Permission G</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">Receipt Id: {{ $tanda_terima_head->receipt_id }}</label>
                                        <input type="hidden" name="receipt_id" id="receipt_id" class="form-control" value="{{ $tanda_terima_head->receipt_id }}" required readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10 mb-2">
                                        <label for="desc"><b>{{ $tanda_terima_head->keterangan }}</b></label>
                                    </div>
                                    <div class="col-md-2 mb-2 float-right">
                                        <label for="id"><b>{{ $tanda_terima_head->keterangan_id }}</b></label>
                                    </div>
                                </div>
                                <div class="row" hidden>
                                    <div class="col-md-10 mb-2">
                                       
                                    </div>
                                    <div class="col-md-2 mb-2 float-right">
                                        <label for="id">{{ $tanda_terima_head->date_receipt }}</label>
                                    </div>
                                </div>

                                
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Jenis Pengeluaran</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Nominal Tagihan</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Nominal Cek/giro</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Cek/giro</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Tanggal</th>
                                                    <th colspan="3" style="text-align: center;">Sumber Dana</th>
                                                    <th colspan="4" style="text-align: center;">Tujuan Cek/giro</th>  
                                                    <th rowspan="2" style="vertical-align: middle;">#</th>
                                                    <th rowspan="2" style="vertical-align: middle;" hidden>No SPP</th>
                                                    <th rowspan="2" style="vertical-align: middle;" hidden>No Kontrabon</th>   
                                                    <tr>
                                                        <th>Perusahaan</th>
                                                        <th>Bank</th>
                                                        <th>No. Rek</th>
                                                        <th>Vendor</th>
                                                        <th>Tujuan Cek/giro</th>
                                                        <th>Bank</th>
                                                        <th>No. Rek</th>
                                                    </tr>  
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @forelse ($tanda_terima_detail as $row)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="jenis_pengeluaran[]" id="jenis_pengeluaran" style="font-size: 13px;" value="{{ $row->jenis_pengeluaran }}" readonly hidden>
                                                        {{ $row->jenis_pengeluaran }}
                                                    </td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="total[]" id="total" style="font-size: 13px;" value="{{ number_format($row->total) }}" readonly hidden>
                                                        {{ number_format($row->total) }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="cek_giro[]" id="cek_giro" style="font-size: 13px;" value="{{ $row->cek_giro }}" readonly hidden>
                                                        {{ $row->cek_giro }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="tanggal[]" id="tanggal" style="font-size: 13px;" value="{{ $row->tanggal }}" readonly hidden>
                                                        {{ $row->tanggal }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="kd_perusahaan[]" id="kd_perusahaan" style="font-size: 13px;" value="{{ $row->kd_perusahaan }}" readonly hidden>
                                                        {{ $row->kd_perusahaan }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="bank[]" id="bank" style="font-size: 13px;" value="{{ $row->bank }}" readonly hidden>
                                                        {{ $row->bank }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="norek_perusahaan[]" id="norek_perusahaan" style="font-size: 13px;" value="{{ $row->norek_perusahaan }}" readonly hidden>
                                                        {{ $row->norek_perusahaan }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="vendor[]" id="vendor" style="font-size: 13px;" value="{{ $row->vendor }}" readonly hidden>
                                                        {{ $row->vendor }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="atas_nama[]" id="atas_nama" style="font-size: 13px;" value="{{ $row->atas_nama }}" readonly hidden>
                                                        {{ $row->atas_nama }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="bank_vendor[]" id="bank_vendor" style="font-size: 13px;" value="{{ $row->bank_vendor }}" readonly hidden>
                                                        {{ $row->bank_vendor }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="norek_vendor[]" id="norek_vendor" style="font-size: 13px;" value="{{ $row->norek_vendor }}" readonly hidden>
                                                        {{ $row->norek_vendor }}
                                                    </td>
                                                    <td>
                                                        @if($row->status == '0')
                                                            <input name="chk[]" type="checkbox" value="{{ $row->cek_giro }}" unchecked />
                                                        @elseif($row->status == '1')
                                                            <input name="chk[]" type="checkbox" value="{{ $row->cek_giro }}" checked />
                                                        @endif
                                                    </td>
                                                    <td hidden>
                                                        <input type="text" class="form-control" name="no_spp[]" id="no_spp" style="font-size: 13px;" value="{{ $row->no_spp }}" readonly hidden>
                                                        {{ $row->no_spp }}
                                                    </td>
                                                    <td hidden>
                                                        <input type="text" class="form-control" name="no_kontrabon[]" id="no_kontrabon" style="font-size: 13px;" value="{{ $row->no_kontrabon }}" readonly hidden>
                                                        {{ $row->no_kontrabon }}
                                                    </td>
                                                    @php $no++; @endphp
                                                </tr>
                                                @empty
                                                <tr>
                                                
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;">Total</th>
                                                <th colspan="1" style="text-align: right;">{{ number_format($total_jml) }}</th>
                                                <th colspan="9" style="text-align: left;">total usage cek/giro: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $count }}</th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row"> 
                                    

                                </div>
                                
                                <div class="row">
                                    <div class="col-md-10 mb-2">
                                        @if(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                            <a href="{{ route('tanda_terima/pdf.pdf', $tanda_terima_head->receipt_id) }}" target="_blank" class="btn btn-warning btn-sm" hidden><b>P r i n t</b></a>  

                                            @if($tanda_terima_head->status  == '0')
                                                <!-- <a href="{{ route('approval_c-approved', $tanda_terima_head->receipt_id) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                                &nbsp;&nbsp;&nbsp;
                                                <!-- <a href="{{ route('approval_c-pending', $tanda_terima_head->receipt_id) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            @elseif($tanda_terima_head->status == '1')
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                &nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            @elseif($tanda_terima_head->status == '2')
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                &nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            @elseif($tanda_terima_head->status == '3')
                                                <!-- <a href="#" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                                &nbsp;&nbsp;&nbsp;
                                                <!-- <a href="#" class="btn btn-warning btn-sm">Pending</a> -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            @endif
                                        @elseif(Auth::user()->kode_divisi == '14') <!-- Jika BOD-->
                                            <a href="{{ route('tanda_terima/pdf.pdf', $tanda_terima_head->receipt_id) }}" target="_blank" class="btn btn-warning btn-sm" hidden><b>P r i n t</b></a>  

                                            @if($tanda_terima_head->status  == '1')
                                                <!-- <a href="{{ route('approval_c-approved', $tanda_terima_head->receipt_id) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                                &nbsp;&nbsp;&nbsp;
                                                <!-- <a href="{{ route('approval_c-pending', $tanda_terima_head->receipt_id) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            @elseif($tanda_terima_head->status == '2')
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                &nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            @elseif($tanda_terima_head->status == '3')
                                                <!-- <a href="#" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                                &nbsp;&nbsp;&nbsp;
                                                <!-- <a href="#" class="btn btn-warning btn-sm">Pending</a> -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            @endif
                                        @endif
                                        
                                    </div> 

                                    <!-- MODAL APPROVED -->
                                            <div class="modal fade" id="modalTambahPesan_approve" tabindex="-1" aria-labelledby="modalTambahPesan_approve" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('approval_g-approved') }}" method="post">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" id="savedatas" name="savedatas" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    
                                    <!-- MODAL Pending -->
                                            <div class="modal fade" id="modalTambahPesan_pending" tabindex="-1" aria-labelledby="modalTambahPesan_pending" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk keterangan ditunda  </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('approval_g-pending', $tanda_terima_head->receipt_id) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->

                                    <div class="col-md-2 mb-2">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">k e m b a l i</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            
        </div>
    </div>
</main>

@endsection

@section('script')



@endsection


