@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        $('#savedatas').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("approval_b-approved") }}',
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
    <title>View Approval Permission B</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
         @if(Auth::user()->kode_divisi == '14') <!-- Jika user login BOD, kode divisi 14 -->
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Approval Izin</li>
            <li class="breadcrumb-item">Izin B</li>
            <li class="breadcrumb-item active">View Izin B</li>
        @else
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Finance</li>
            <li class="breadcrumb-item">Approval</li>
            <li class="breadcrumb-item">Approval B</li>
            <li class="breadcrumb-item active">View Approval Permission B</li>
        @endif
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('approval_b-approved') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Approval Permission B</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-2 mb-2">
                                        Kode Izin B
                                        <input type="text" name="kode_izin" id="kode_izin" class="form-control" value="" required readonly>
                                        <input type="hidden" name="no_urut" id="no_urut" class="form-control" value="" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Tanggal Izin
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="" required readonly>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        No.Izin
                                        <input type="text" name="no_izin" id="no_izin" class="form-control" value="" required readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Judul Izin <!-- Keterangan -->
                                        <textarea name="judul_izin" id="judul_izin" rows="1" class="form-control" required readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Nama Rekening Pembayar
                                        <div class="input-group">
                                            <input type="hidden" name="kode_perusahaan" id="kode_perusahaan" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                            <input type="hidden" name="nama_perusahaan" id="nama_perusahaan" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                            <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Nama Bank
                                        <input type="hidden" name="kode_bank" id="kode_bank" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                        <input type="text" name="bank_pembayar" id="bank_pembayar" class="form-control" value="" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        No. Rekening Pembayar
                                        <input type="text" name="norek_pembayar" id="norek_pembayar" class="form-control" value="" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 mb-2">
                                        Keterangan <!-- Keterangan -->
                                        <textarea name="keterangan" id="keterangan" rows="1" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <div>
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                                                    <th colspan="2" style="text-align: center;">Data Warkat</th>
                                                    <th colspan="4" style="text-align: center;">Tujuan Cek</th>
                                                </tr>
                                                <tr align="center">
                                                    <th style="vertical-align: middle;">No Seri Awal</th>
                                                    <th style="vertical-align: middle;">No Seri Akhir</th>
                                                    <th style="vertical-align: middle;">Nama Vendor</th>
                                                    <th style="vertical-align: middle;">Nama Rekening</th>
                                                    <th style="vertical-align: middle;">Bank</th>
                                                    <th style="vertical-align: middle;">No Rekening</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_warkat">
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <input type="hidden" name="kode_seri[]" id="kode_seri_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                        <input type="text" name="seri_awal[]" id="seri_awal_1" class="form-control" style="font-size: 12px; height: 30px; width: 100px;" value="" readonly>
                                                        <input type="hidden" name="kode_warkat[]" id="kode_warkat_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                        <input type="hidden" name="no_cek[]" id="no_cek_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="kode_seri_akhir[]" id="kode_seri_akhir_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                        <input type="text" name="seri_akhir[]" id="seri_akhir_1" class="form-control" style="font-size: 12px; height: 30px; width: 100px;" value="" readonly>
                                                        <input type="hidden" name="no_cek_akhir[]" id="no_cek_akhir_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="kode_vendor[]" id="kode_vendor_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                        <input type="text" name="vendor[]" id="vendor_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button type="submit" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Approved</button>
                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return hapusbaris('tabelinput')">Pending</button>
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm">Denied</button>
                                    </div>  
                                  
                                    <div class="col-md-8 mb-2">
                                        <!-- <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Simpan</button> -->
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-primary btn-sm float-right">Kembali</button>
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

@section('script')



@endsection


