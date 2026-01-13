@section('js')
<script type="text/javascript">
    
    // $("#button_form_back").click(function() {
    //     window.history.back();
    // });

    $("#button_form_approved").click(function() {
        let no_urut = $("#no_urut").val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('remun/approved.approved') }}",
            data: {
                no_urut: no_urut,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('remun.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_denied").click(function() {

    });

    $("#button_form_pending").click(function() {

    });

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>View Remunerasi</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Remunerasi</li>
        <li class="breadcrumb-item active">View Remunerasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="#" onkeypress="return event.keyCode != 13" enctype="multipart/form-data"> 
           
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">View Remunerasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- <label for="principal" class="col-sm-2 col-form-label">No PTK Calon Karyawan</label> -->
                                <div class="col-md-3 mb-2" hidden>
                                    <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $data_remun_head->no_urut }}" required>
                                    <input type="text" name="no_ptk" id="no_ptk" class="form-control" value="{{ $data_remun_head->no_ptk }}" readonly>
                                </div>

                                <label for="entitas" class="col-sm-2 col-form-label">Nama Calon Karyawan</label>
                                <div class="col-md-3 mb-2">
                                    <input id="nama" name="nama" type="text" class="form-control" value="{{ $data_remun_head->nama }}" readonly required>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="principal" class="col-sm-2 col-form-label">ID Finger</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="id_finger" id="id_finger" class="form-control" value="{{ $data_remun_head->id_finger }}" required readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="entitas" class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ $data_remun_head->jabatan }}" readonly>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="entitas" class="col-sm-2 col-form-label">Id DMS</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="id_dms" id="id_dms" class="form-control" value="{{ $data_remun_head->id_dms }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="entitas" class="col-sm-2 col-form-label">Lokasi Kerja</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ $data_remun_head->depo }}" readonly>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="entitas" class="col-sm-2 col-form-label">Tgl Masuk</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="tgl_masuk" id="tgl_masuk" class="form-control" value="{{ $data_remun_head->tgl_masuk }}" readonly>
                                </div>
                            </div>
                            
                            <div class="row" hidden>
                                <label for="entitas" class="col-sm-2 col-form-label">GP Base</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="base" id="base" class="form-control" value="{{ $data_remun_head->area }}" readonly>
                                </div>
                                <div class="col-sm-2"></div>
                                
                            </div>
                            <div class="row">
                                <label for="entitas" class="col-sm-2 col-form-label">Jenis Remun</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="jenis_remun" id="jenis_remun" class="form-control" value="{{ $data_remun_head->jenis_remun }}" readonly>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="entitas" class="col-sm-2 col-form-label">Tgl Berlaku</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="tgl_masuk" id="tgl_masuk" class="form-control" value="{{ $data_remun_head->tgl_berlaku }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="entitas" class="col-sm-2 col-form-label">Periode Dari</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="tgl_periode_dari" id="tgl_periode_dari" class="form-control" value="{{ $data_remun_head->tgl_periode_dari }}" readonly>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="entitas" class="col-sm-2 col-form-label">sampai</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="tgl_peruide_sampai" id="tgl_peruide_sampai" class="form-control" value="{{ $data_remun_head->tgl_periode_sampai }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="pencairan" class="col-sm-2 col-form-label">Remun dicairkan di</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="pencairan" id="pencairan" class="form-control" value="{{ $data_remun_head->pencairan }}" readonly>
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
                                    <div style="display: flex; gap: 20px; overflow-x: auto;">
                                        <table border="1" cellspacing="0" cellpadding="5" style="font-size:12px; width:100%;">
                                            <thead>
                                                <tr style="background-color:aqua; font-weight:bold; text-align:center;">
                                                    <th colspan="15">REMUNERASI CALON KARYAWAN</th>
                                                </tr>
                                                <tr style="font-weight:bold;">
                                                    <th style="text-align:center;">No</th>
                                                    <th colspan="15" align="left">Tunjangan:</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_tunjangan">
                                                <?php $no=1 ?>
                                                @forelse($data_remun_detail as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->nama_tunjangan }}</td>
                                                    <td align="right">{{ number_format($val->nilai)}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data untuk saat ini</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr style="font-weight:bold;">
                                                    <th colspan="2" style="text-align:center; font-size: 15px;">T O T A L</th>
                                                    <th id="total_nilai" style="text-align:right;">Rp. {{ number_format($total->total) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    
                                    @if(Auth::user()->type == 'Manager')
                                        @if(Auth::user()->kode_divisi == '1')
                                            @if($data_remun_head->status_atasan  == '1')
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" hidden>Approved</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" hidden>Denied</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" hidden>Pending</button>
                                                </div>
                                            @elseif($data_remun_head->status_atasan  == '2')
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($data_remun_head->status_atasan  == '3')
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif
                                        @elseif(Auth::user()->kode_divisi == '6')
                                            @if(Auth::user()->kode_sub_divisi == '4')
                                                @if($data_remun_head->status_biaya_pusat_koor  == '1')
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-success btn-sm" hidden>Approved</button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-danger btn-sm" hidden>Denied</button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-warning btn-sm" hidden>Pending</button>
                                                    </div>
                                                @elseif($data_remun_head->status_biaya_pusat_koor  == '2')
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                    </div>
                                                @elseif($data_remun_head->status_biaya_pusat_koor  == '3')
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                            Approved
                                                        </button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                            Denied
                                                        </button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                            Pending
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                            Approved
                                                        </button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                            Denied
                                                        </button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                            Pending
                                                        </button>
                                                    </div>
                                                @endif
                                            @elseif(Auth::user()->kode_sub_divisi == '5')
                                                @if($data_remun_head->status_biaya_pusat  == '1')
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-success btn-sm" hidden>Approved</button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-danger btn-sm" hidden>Denied</button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-warning btn-sm" hidden>Pending</button>
                                                    </div>
                                                @elseif($data_remun_head->status_biaya_pusat  == '2')
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                    </div>
                                                @elseif($data_remun_head->status_biaya_pusat  == '3')
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                            Approved
                                                        </button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                            Denied
                                                        </button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                            Pending
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                            Approved
                                                        </button>
                                                    </div>
                                            
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                            Denied
                                                        </button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                            Pending
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                    <!-- <div class="col-md-9 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm float-right" id="button_form_back">
                                            K e m b a l i
                                        </button>
                                    </div>    -->
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


@endsection