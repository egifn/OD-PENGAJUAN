@section('js')
<script type="text/javascript">

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Penerimaan Izin E</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item">Izin G</li>
        <li class="breadcrumb-item active">Penerimaan Izin G</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('tanda_terima_g/store_terima.store_terima') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Penerimaan Izin g</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Kode Izin G
                                        <input type="text" name="kode_izin_g" id="kode_izin_g" class="form-control" value="{{ $header->kode_izin_g }}" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Tanggal Kirim
                                        <input type="text" name="tgl_kirim" id="tgl_kirim" class="form-control" value="{{ date('d-M-Y', strtotime($header->tgl_kirim)) }}" required disabled>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        No.Izin
                                        <input type="text" name="no_izin" id="no_izin" class="form-control" value="{{ $header->no_izin_g }}" required disabled>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Judul Izin <!-- Keterangan -->
                                        <textarea name="judul_izin" id="judul_izin" rows="1" class="form-control" required disabled>{{ $header->judul_izin_g }}</textarea>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Catatan <!-- Keterangan -->
                                        <input type="text" name="catatan" id="catatan" class="form-control" value="{{ $header->catatan }}" disabled>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Penerima
                                        <select name="kode_penerima_resi" id="kode_penerima_resi" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Ratna pany</option>
                                            <option value="2">Cinta M.Tampubolon</option>
                                            <option value="3">Razel G. kaawoan</option>
                                            <option value="4">Nany Enggawati</option>
                                            <option value="5">Amelina</option>
                                            <option value="6">Lie Kwie Moy</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut <!-- Keterangan -->
                                        <input type="hidden" name="no_urut" id="no_urut" class="form-control" value="{{ $header->no_urut }}">
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>

                    
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div>
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <thead>
                                                    <tr>
                                                        <th style="vertical-align: middle;"></th>
                                                        <th style="vertical-align: middle;">No</th>
                                                        <th style="vertical-align: middle;">No Cek/Giro/Slip</th>
                                                        <th style="vertical-align: middle; width: 300px;">Perusahaan</th>
                                                        <th style="vertical-align: middle;">Bank</th>
                                                        <th style="vertical-align: middle;">No Rekening</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_warkat">
                                                @php $no = 1; @endphp
                                                    @forelse ($details as $row)
                                                    <tr>
                                                        <td align="center">
                                                                <input name="chk[]" id="chk_{{ $no }}" type="checkbox" class="checkbox" data-index="{{ $no }}" value="{{ $row->no_cek }}" />
                                                        </td>
                                                        <td>
                                                            <input type="hidden" style="height: 30px;" class="form-control" name="nomor[]" id="nomor_{{ $no }}" value = "{{ $no }}" style="font-size: 13px;">
                                                            {{ $no }}
                                                        </td>
                                                        <td align="center">
                                                            {{ $row->no_cek }}
                                                        </td>
                                                        <td>
                                                            {{ $row->nama_perusahaan }}
                                                        </td>
                                                        <td>
                                                            {{ $row->nama_bank }}
                                                        </td>
                                                        <td align="center">
                                                            {{ $row->no_rekening }}
                                                        </td>
                                                        @php $no++; @endphp
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
                                        <!-- <div class="col-md-10 mb-2"></div> -->
                                        <div class="col-md-12 mb-2">
                                            <button type="submit" class="btn btn-success btn-sm float-right">Terima</button>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </form>
        </div>
    </div>
</main>


@endsection