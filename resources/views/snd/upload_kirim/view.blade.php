@section('js')

<script type="text/javascript">
    function goBack() {
        window.history.back();
    }


</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Upload dan Kirim Surat Program</title>
@endsection

@section('content')
   
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Surat Program</li>
        <li class="breadcrumb-item">Upload dan Kirim Surat Program</li>
        <li class="breadcrumb-item active">View Upload dan Kirim Surat Program</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                    <h4 class="card-title">Upload dan Kirim Surat Program</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-2 mb-2">
                                        Jenis Surat
                                        <input type="text" name="jenis_surat" id="jenis_surat" class="form-control" value=" {{ $data_claim_program->jenis_surat }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2">
                                        Tgl Upload dan Kirim
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime($data_claim_program->tgl_upload_kirim)) }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $data_claim_program->name }}" required readonly>
                                        <input type="hidden" name="id_user_input" id="id_user_input" class="form-control" value="{{ $data_claim_program->id_user_input }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan_user" id="kode_perusahaan_user" class="form-control" value="{{ $data_claim_program->kode_perusahaan_user }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="kode_depo_user" id="kode_depo_user" class="form-control" value="{{ $data_claim_program->kode_depo_user }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Divisi
                                        <input type="text" name="kode_divisi_user" id="kode_divisi_user" class="form-control" value="{{ $data_claim_program->kode_divisi_user }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No. Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $data_claim_program->no_urut }}">
                                    </div>
                                </div>

                                <hr>
                                {{-- <div id="form-input-satu">
                                    <div id="form-input-satu" class="field_wrapper_2">
                                        <div id="form-input-satu" class="row">

                                        </div>
                                    </div>
                                </div>

                                <div id="form-input-satu">
                                    <div id="form-input-satu" class="field_wrapper_2">
                                        <div id="form-input-satu" class="row">

                                        </div>
                                    </div>
                                </div> --}}
                                @if(Auth::user()->kode_sub_divisi == '15' || Auth::user()->kode_sub_divisi == '14' || Auth::user()->kode_sub_divisi == '13') {{--Jika SPV--}}

                                @else
                                    @if($data_claim_program->jenis_surat == 'Eksternal')

                                        <div id="form-input-tiv">
                                            <div class="field_wrapper_tiv">


                                                <h4>Surat Program TIV</h4>
                                                <div class="row">
                                                    <div class="col-md-2 mb-2">
                                                        ID Program
                                                        <input type="text" name="id_program_tiv" id="id_program_tiv" class="form-control" value="{{ $data_claim_program->id_program }}" readonly>
                                                    </div>

                                                    <div class="col-md-9 mb-2">
                                                        Nama Program
                                                        <input type="text" name="nama_program_tiv" id="nama_program_tiv" class="form-control" value="{{ $data_claim_program->nama_program }}" readonly>
                                                    </div>

                                                    <div class="col-md-1 mb-2">
                                                        Jml Peserta
                                                        <input type="text" style="text-align: right;" name="jml_peserta" id="jml_peserta" class="form-control" value="{{ $data_claim_program->jml_peserta }}" readonly>
                                                    </div>
                                                </div>
                                            
                                                <div class="row">
                                                    
                                                </div>
                                        
                                                <br>
                                            
                                                <div class="card">
                                                    <div class="table-responsive">    
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <td>
                                                                    <strong>Lampiran/Attachment Surat Program</strong>
                                                                    <div class="table-responsive">
                                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                            <tbody>
                                                                                <?php $no=1 ?>
                                                                                @forelse ($data_upload_program_tiv as $row)
                                                                                <tr>
                                                                                    {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                                    <td>
                                                                                        <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                            {{ $row->filename_upload}}
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
                                                                    <br>
                                                                </td>
                    
                                                                <td>
                                                                    <strong>Lampiran/Attachment Lain-lain</strong>
                                                                    <div class="table-responsive">
                                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                            <tbody>
                                                                                <?php $no=1 ?>
                                                                                @forelse ($data_upload_pendukung as $row)
                                                                                <tr>
                                                                                    {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                                    <td>
                                                                                        <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                            {{ $row->filename_upload}}
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
                                                                    <br>
                                                                </td>
                                                            </table>
                                                        </div>
                
                                                    </div>
                                                    
                                                </div>
                                                
                                                <hr>
                                            </div>
                                        </div>

                                    @endif
                                @endif
                                
                                <h4>Surat Distributor</h4>
                                <div class="row">
                                    {{-- <div class="col-md-2 mb-2">
                                        No. Surat
                                        <input type="text" name="no_surat" id="no_surat" class="form-control" value="" required>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        ID Program
                                        <input type="text" name="id_program" id="id_program" class="form-control" value="" required>
                                    </div> --}}

                                    <div class="col-md-8 mb-2">
                                        Nama Program
                                        <input type="text" name="nama_program_distributor" id="nama_program_distributor" class="form-control" value="{{ $data_claim_program->nama_program }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Periode Awal
                                        <input type="text" name="periode_awal" id="periode_awal" class="form-control" value="{{ date('d-M-Y', strtotime($data_claim_program->periode_awal)) }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Periode Akhir
                                        <input type="text" name="periode_akhir" id="periode_akhir" class="form-control" value="{{ date('d-M-Y', strtotime($data_claim_program->periode_akhir)) }}" readonly>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Penerima
                                        <input type="text" name="penerima" id="penerima" class="form-control" value="{{ $data_claim_program->penerima }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Kategori
                                        <input type="text" name="kategori" id="kategori" class="form-control" value="{{ $data_claim_program->kategori_program }}" readonly>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        SKU
                                        <input type="text" name="sku" id="sku" class="form-control" value="{{ $skuArrayToString }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Channel/Segmen
                                        <input type="text" name="channel" id="channel" class="form-control" value="{{ $segmenArrayToString }}" readonly>
                                    </div>
                                </div>
                                <br>

                                {{-- <h5>* Wenang Palm Solusindo</h5>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Untuk Perusahaan
                                        <select name="id_perusahaan_ta" id="id_perusahaan_ta" class="form-control">
                                            <option value="WPS">Wenang Palm Solusindo</option>
                                        </select>
                                       
                                    </div>

                                    <div class="col-md-8">
                                        <strong>Lampiran/Attachment</strong>
                                        <input type="file" class="form-control" name="filenameta[]" id="filenameta_1" multiple>
                                    </div>
                                </div>

                                <div id="form-input">
                                    <div class="field_wrapper_ta">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                Untuk Depo
                                                <select name="id_depo_ta[]" id="id_depo_ta_1" class="form-control">
                                                    <option value="">Pilih Depo</option>
                                                   
                                                </select>
                                            </div>
        
                                              
                                            <div class="col-md-1 mb-2">
                                                <br>
                                                <a class="btn btn-primary" href="javascript:void(0);" id="add_button_ta" title="Add field">+</a>                                        
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <br>
                                <h5>* Lokon Prima</h5>
                                <div class="row">
                                    
                                    <div class="col-md-4 mb-2">
                                        Untuk Perusahaan
                                        <select name="id_perusahaan_tu" id="id_perusahaan_tu" class="form-control">
                                            <option value="LP">Lokon Prima</option>
                                        </select>
                                       
                                    </div>

                                    <div class="col-md-8">
                                        <strong>Lampiran/Attachment</strong>
                                        <input type="file" class="form-control" name="filenametu[]" id="filenametu_1" multiple>
                                    </div>
                                </div>

                                <div id="form-input">
                                    <div class="field_wrapper_tu">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                Untuk Depo
                                                <select name="id_depo_tu[]" id="id_depo_tu_1" class="form-control">
                                                    <option value="">Pilih Depo</option>
                                                    
                                                </select>
                                               
                                            </div>
                                              
                                            <div class="col-md-1 mb-2">
                                                <br>
                                                <a class="btn btn-primary" href="javascript:void(0);" id="add_button_tu" title="Add field">+</a>                                        
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <br>
                                <h5>* Tirta Utama Abadi</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Untuk Perusahaan
                                        <select name="id_perusahaan_tua" id="id_perusahaan_tua" class="form-control">
                                            <option value="TUA">Tirta Utama Abadi</option>
                                        </select>
                                    </div>

                                    <div class="col-md-8">
                                        <strong>Lampiran/Attachment</strong>
                                        <input type="file" class="form-control" name="filenametua[]" id="filenametua_1" multiple>
                                    </div>
                                </div>

                                <div id="form-input">
                                    <div class="field_wrapper_tua">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                Untuk Depo
                                                <select name="id_depo_tua[]" id="id_depo_tua_1" class="form-control">
                                                    <option value="">Pilih Depo</option>
                                                   
                                                </select>
                                            </div>
        
                                            <div class="col-md-1 mb-2">
                                                <br>
                                                <a class="btn btn-primary" href="javascript:void(0);" id="add_button_tua" title="Add field">+</a>                                        
                                            </div>
                                        </div>    
                                    </div>
                                </div> --}}

                                <div class="card">
                                    <div class="table-responsive">    
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">

                                            @if(Auth::user()->kode_sub_divisi == '15') {{--Jika SPV--}}
                                                @if(Auth::user()->kode_perusahaan == 'WPS') {{--Jika SPV--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> WENANG PALM SOLUSINDO</b>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_ta as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_ta as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @elseif(Auth::user()->kode_perusahaan == 'LP') {{--Jika SPV--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> LOKON PRIMA</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_tu as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_tu as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @elseif(Auth::user()->kode_perusahaan == 'TUA') {{--Jika SPV--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> TIRTA UTAMA ABADI</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_tua as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                                
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_tua as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @endif
                                            @elseif(Auth::user()->kode_sub_divisi == '14') {{--Jika KPJ--}}
                                                @if(Auth::user()->kode_perusahaan == 'WPS') {{--Jika KPJ--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> WENANG PALM SOLUSINDO</b>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_ta as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_ta as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @elseif(Auth::user()->kode_perusahaan == 'LP') {{--Jika KPJ--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> LOKON PRIMA</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_tu as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_tu as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @elseif(Auth::user()->kode_perusahaan == 'TUA') {{--Jika KPJ--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> TIRTA UTAMA ABADI</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_tua as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                                
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_tua as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @endif
                                            @elseif(Auth::user()->kode_sub_divisi == '13') {{--Jika ASM--}}
                                                @if(Auth::user()->kode_perusahaan == 'WPS') {{--Jika ASM--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> WENANG PALM SOLUSINDO</b>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_area as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_ta as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @elseif(Auth::user()->kode_perusahaan == 'LP') {{--Jika ASM--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> LOKON PRIMA</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_area as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_tu as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @elseif(Auth::user()->kode_perusahaan == 'TUA') {{--Jika ASM--}}
                                                    <td>
                                                        <b><i class="nav-icon icon-control-play"></i> TIRTA UTAMA ABADI</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th hidden>no_surat</th>
                                                                        <th>Kode Depo</th>
                                                                        <th>Nama Depo</th>
                                                                        <th hidden>No Urut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $no = 1; @endphp
                                                                    @forelse($data_claim_program_detail_area as $val)
                                                                    <tr>
                                                                        <td>{{ $no++ }}</td>
                                                                        <td hidden>{{ $val->no_surat }}</td>
                                                                        <td>{{ $val->kode_depo }}</td>
                                                                        <td>{{ $val->nama_depo }}</td>
                                                                        <td hidden>{{ $val->no_urut }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                                
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Surat Program</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_program_tua as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                                {{ $row->filename_upload_depo}}
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
                                                        <!-- Approval Surat -->
                                                        <br>
                                                        <strong>Lampiran Approval Surat</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <form action="{{ route('approval_surat_program.pdf_app', $data_claim_program->no_urut) }}" target="_blank" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <button type="submit" style="border: none; background: none; color: rgb(86, 173, 245); text-decoration: underline; cursor: pointer;">
                                                                                    Approval Surat.pdf
                                                                                </button>
                                                                            </form>            
                                                                        </td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <strong>Lampiran/Attachment Pendukung Lainnya</strong>
                                                        <div class="table-responsive">
                                                            <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($data_upload_pendukung as $row)
                                                                    <tr>
                                                                        {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                        <td>
                                                                            <a href="{{url('images/'. $row->filename_upload)}}">
                                                                                {{ $row->filename_upload}}
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
                                                    </td>
                                                @endif
                                            @else

                                                <td>
                                                    <b><i class="nav-icon icon-control-play"></i> WENANG PALM SOLUSINDO</b>
                                                    <div class="table-responsive">
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th hidden>no_surat</th>
                                                                    <th>Kode Depo</th>
                                                                    <th>Nama Depo</th>
                                                                    <th hidden>No Urut</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $no = 1; @endphp
                                                                @forelse($data_claim_program_detail_ta as $val)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td hidden>{{ $val->no_surat }}</td>
                                                                    <td>{{ $val->kode_depo }}</td>
                                                                    <td>{{ $val->nama_depo }}</td>
                                                                    <td hidden>{{ $val->no_urut }}</td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <strong>Lampiran/Attachment</strong>
                                                    <div class="table-responsive">
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <tbody>
                                                                <?php $no=1 ?>
                                                                @forelse ($data_upload_program_ta as $row)
                                                                <tr>
                                                                    {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                    <td>
                                                                        <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                            {{ $row->filename_upload_depo}}
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
                                                </td>

                                                <td>
                                                    <b><i class="nav-icon icon-control-play"></i> LOKON PRIMA</b>
                                                    <div class="table-responsive">
                                                        <!-- <table class="table table-hover table-bordered"> -->
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th hidden>no_surat</th>
                                                                    <th>Kode Depo</th>
                                                                    <th>Nama Depo</th>
                                                                    <th hidden>No Urut</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $no = 1; @endphp
                                                                @forelse($data_claim_program_detail_tu as $val)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td hidden>{{ $val->no_surat }}</td>
                                                                    <td>{{ $val->kode_depo }}</td>
                                                                    <td>{{ $val->nama_depo }}</td>
                                                                    <td hidden>{{ $val->no_urut }}</td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <strong>Lampiran/Attachment</strong>
                                                    <div class="table-responsive">
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <tbody>
                                                                <?php $no=1 ?>
                                                                @forelse ($data_upload_program_tu as $row)
                                                                <tr>
                                                                    {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                    <td>
                                                                        <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                            {{ $row->filename_upload_depo}}
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
                                                </td>

                                                <td>
                                                    <b><i class="nav-icon icon-control-play"></i> TIRTA UTAMA ABADI</b>
                                                    <div class="table-responsive">
                                                        <!-- <table class="table table-hover table-bordered"> -->
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th hidden>no_surat</th>
                                                                    <th>Kode Depo</th>
                                                                    <th>Nama Depo</th>
                                                                    <th hidden>No Urut</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $no = 1; @endphp
                                                                @forelse($data_claim_program_detail_tua as $val)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td hidden>{{ $val->no_surat }}</td>
                                                                    <td>{{ $val->kode_depo }}</td>
                                                                    <td>{{ $val->nama_depo }}</td>
                                                                    <td hidden>{{ $val->no_urut }}</td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                            
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <strong>Lampiran/Attachment</strong>
                                                    <div class="table-responsive">
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <tbody>
                                                                <?php $no=1 ?>
                                                                @forelse ($data_upload_program_tua as $row)
                                                                <tr>
                                                                    {{-- <td><i>Attachment_{{ $no }}</i></td> --}}
                                                                    <td>
                                                                        <a href="{{url('images/'. $row->filename_upload_depo)}}">
                                                                            {{ $row->filename_upload_depo}}
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
                                                </td>

                                            @endif

                                            
                                            </table>
                                        </div>

                                    </div>
                                    
                                </div>

                                <hr>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            
                                            <button type="button" id="kembali" name="kembali" class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>

                                            <button type="button" id="batal" name="batal" class="btn btn-warning btn-sm" hidden>Batal</button>
                                            @if(Auth::user()->kode_divisi == '13') <!--SND-->
                                                @if(Auth::user()->kode_sub_divisi == '12') <!--SSD-->
                                                    @if($data_claim_program->status_approval_ssd  == '1') <!-- 2: approved -->
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                        
                                                    @elseif($data_claim_program->status_approval_ssd == '2') <!-- 3: denied -->
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                        
                                                    @elseif($data_claim_program->status_approval_ssd == '3') <!-- 4: Pending -->
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                            Approved
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                            Denied
                                                        </button>
                                                        
                                                    @else
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                            Approved
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                            Denied
                                                        </button>
                                                        
                                                    @endif
                                                @elseif(Auth::user()->kode_sub_divisi == '16') <!--SOM-->
                                                    @if($data_claim_program->status_approval_som  == '1') <!-- 2: approved -->
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                        
                                                    @elseif($data_claim_program->status_approval_som == '2') <!-- 3: denied -->
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                        
                                                    @elseif($data_claim_program->status_approval_som == '3') <!-- 4: Pending -->
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                            Approved
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                            Denied
                                                        </button>
                                                        
                                                    @else
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                            Approved
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                            Denied
                                                        </button>
                                                       
                                                    @endif
                                                @elseif(Auth::user()->kode_sub_divisi == '13') <!--ASM-->
                                                    {{-- <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">Denied</button>
                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">Approve</button> --}}
                                                @else
                                                    @if(Auth::user()->type == 'Admin')
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" hidden>Approve</button>
                                                    @elseif(Auth::user()->type == 'Manager') <!--Manager SND-->
                                                        @if($data_claim_program->status_approval_manager  == '1') <!-- 2: approved -->
                                                            
                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm " disabled>Approve</button>
                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm " disabled>Denied</button>
                                                        @elseif($data_claim_program->status_approval_manager == '2') <!-- 3: denied -->
                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm " disabled>Approve</button>
                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm " disabled>Denied</button>
                                                        @elseif($data_claim_program->status_approval_manager == '3') <!-- 4: Pending -->
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                Approved
                                                            </button>
                                                        
                                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                Denied
                                                            </button>
                                                        @else
                                                           
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                Approved
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                Denied
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </div>  
                                    </div>
                                </div> 

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
                                                <!--FORM TAMBAH BARANG-->
                                                <form action="{{ route('approval-surat-program-update', $data_claim_program->no_urut) }}" method="get">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $data_claim_program->no_urut }}" required readonly>
                                                        <label for="">keterangan</label>
                                                        <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                </form>
                                                <!--END FORM TAMBAH BARANG-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Isi untuk Keterangan..</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!--FORM TAMBAH BARANG-->
                                                <form action="{{ route('approval-surat-program-denied', $data_claim_program->no_urut) }}" method="get">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $data_claim_program->no_urut }}" required readonly>
                                                        <label for="">keterangan</label>
                                                        <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                </form>
                                                <!--END FORM TAMBAH BARANG-->
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


@endsection

@section('script')

    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: false,
                bFilter: false,
                lengthChange: false,
                scrollY: "355px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

    F

@endsection




