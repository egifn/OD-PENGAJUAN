@section('js')
<script type="text/javascript">


</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Monitoring Kasir</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Monitoring Kasir</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data"> 
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Monitoring Kasir</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                        <label for="principal" class="col-sm-2 col-form-label">PRINCIPAL</label>
                                        <div class="col-sm-3">
                                            <select name="principal" id="principal" class="form-control form-control-sm">
                                                <option value="">Pilih</option>
                                                <option value="PT. TIRTA INVESTAMA" {{ request('principal') == 'PT. TIRTA INVESTAMA' ? 'selected' : '' }}>PT. TIRTA INVESTAMA</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="entitas" class="col-sm-2 col-form-label">ENTITAS</label>
                                        <div class="col-sm-3">
                                            <select name="kode_perusahaan" id="kode_perusahaan" class="form-control form-control-sm">
                                                <option value="">Pilih</option>
                                                @foreach ($perusahaan as $item)
                                                    <option value="{{ $item->kode_perusahaan }}" {{ request('kode_perusahaan') == $item->kode_perusahaan ? 'selected' : '' }}>
                                                    {{ $item->kode_perusahaan }} - {{ $item->nama_perusahaan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="depo" class="col-sm-2 col-form-label">DEPO</label>
                                        <div class="col-sm-3">
                                            <select name="kode_depo" id="kode_depo" class="form-control form-control-sm">
                                                <option value="">Pilih</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tgl_dari" class="col-sm-2 col-form-label">BULAN</label>
                                        <div class="col-sm-3">
                                            <select class="form-control form-control-sm" name="bulan" id="bulan" data-id="0">
                                            <option value="" {{ request('bulan') == '' ? 'selected' : '' }}>Cari Bulan</option>
                                            <option value="1" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari 2025</option>
                                            <option value="2" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari 2025</option>
                                            <option value="3" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret 2025</option>
                                            <option value="4" {{ request('bulan') == '04' ? 'selected' : '' }}>April 2025</option> 
                                            <option value="5" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei 2025</option>
                                            <option value="6" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni 2025</option>
                                            <option value="7" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli 2025</option>
                                            <option value="8" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus 2025</option>
                                            <option value="9" {{ request('bulan') == '09' ? 'selected' : '' }}>September 2025</option>
                                            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober 2025</option>
                                            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November 2025</option>
                                            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember 2025</option>
                                        </select>
                                        </div>

                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-primary btn-sm">C a r i</button>
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
                                        <table border="1" cellspacing="0" cellpadding="5" style="text-align:center; font-size:12px; width:100%;">
                                            <thead>
                                                <tr style="background-color:gold; font-weight:bold;">
                                                    <th colspan="15">KAS DIREKSI</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th rowspan="3">TGL</th>
                                                    <th rowspan="3">SALDO AWAL</th>
                                                    <th colspan="4">PENERIMAAN KASIR (PLUS)</th>
                                                    <th colspan="5">PENGELUARAN / PENYETORAN KASIR (MINUS)</th>
                                                    <th rowspan="3">SALDO AKHIR</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th colspan="2">PENJUALAN</th>
                                                    <th colspan="2">PELUNASAN</th>
                                                    <th colspan="3">PENJUALAN</th>
                                                    <th colspan="2">PELUNASAN</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th>TUNAI</th>
                                                    <th>TRANSFER</th>
                                                    <th>TUNAI</th>
                                                    <th>CEK/GIRO/TRANSFER</th>
                                                    <th>KE BANK</th>
                                                    <th>PETTY CASH</th>
                                                    <th>TRANSFER</th>
                                                    <th>TUNAI</th>
                                                    <th>CEK/GIRO/TRANSFER</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no=1;
                                                @endphp
                                                @foreach ($monitoring as $data)
                                                <tr>
                                                    <td style="padding: 7px 5px;" align="right">{{ $no++ }}</td>
                                                    <td style="padding: 7px 5px;" align="right"></td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Penjualan_Tunai) }}</td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Penjualan_Tunai_Transfer) }}</td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Tagihan_Tunai) }}</td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Tagihan_Non_Tunai) }}</td>
                                                    <td style="padding: 7px 5px;" align="right">0</td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Pengeluaran_Petty_Cash) }}</td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Pengeluaran_Biaya) }}</td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Setoran_Tagihan_Tunai) }}</td>
                                                    <td style="padding: 7px 5px;" align="right">{{ number_format($data->Setoran_Tagihan_Non_Tunai) }}</td>
                                                    <td style="padding: 7px 5px;" align="right"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <table border="1" cellspacing="0" cellpadding="5" style="text-align:center; font-size:12px; width:100%;">
                                            <thead>
                                                <tr style="background-color:Aqua; font-weight:bold;">
                                                    <th colspan="15">BANK DIREKSI</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th rowspan="3">SALDO AWAL BANK DIREKSI</th>
                                                    <th colspan="4">PENERIMAAN</th>
                                                    <th rowspan="3">SALDO AKHIR BANK DIREKSI</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th colspan="2">PENJUALAN</th>
                                                    <th colspan="2">PELUNASAN</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th>TUNAI</th>
                                                    <th>TRANSFER</th>
                                                    <th>TUNAI</th>
                                                    <th>CEK/GIRO/TRANSFER</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no=1;
                                                @endphp
                                                @foreach ($monitoring as $data)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ number_format($data->Penjualan_Tunai) }}</td>
                                                    <td>{{ number_format($data->Penjualan_Tunai_Transfer) }}</td>
                                                    <td>{{ number_format($data->Setoran_Tagihan_Tunai) }}</td>
                                                    <td>{{ number_format($data->Setoran_Tagihan_Non_Tunai) }}</td>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <table border="1" cellspacing="0" cellpadding="5" style="text-align:center; font-size:12px; width:100%;">
                                            <thead>
                                                <tr style="background-color:Aquamarine; font-weight:bold;">
                                                    <th colspan="15">SELISIH</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th colspan="4">PENERIMAAN KASIR VS SETORAN KASIR</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th colspan="2">PENJUALAN</th>
                                                    <th colspan="2">PELUNASAN</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th>TUNAI</th>
                                                    <th>TRANSFER</th>
                                                    <th>TUNAI</th>
                                                    <th>CEK/GIRO/TRANSFER</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no=1;
                                                @endphp
                                                @foreach ($monitoring as $data)
                                                <tr>
                                                    <td>{{ number_format($data->Penjualan_Tunai) }}</td>
                                                    <td>{{ number_format($data->Penjualan_Tunai_Transfer) }}</td>
                                                    <td>{{ number_format($data->Setoran_Tagihan_Tunai) }}</td>
                                                    <td>{{ number_format($data->Setoran_Tagihan_Non_Tunai) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <table border="1" cellspacing="0" cellpadding="5" style="text-align:center; font-size:12px; width:100%;">
                                            <thead>
                                                <tr style="background-color:Aquamarine; font-weight:bold;">
                                                    <th colspan="15">SELISIH</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th colspan="3">PENJUALAN CASH VS KASIR</th>
                                                </tr>
                                                <tr style="background-color:#fce4d6;">
                                                    <th>PENJUALAN</th>
                                                    <th>KASIR</th>
                                                    <th>SELISIH</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no=1;
                                                @endphp
                                                @foreach ($monitoring as $data)
                                                <tr>
                                                    <td>{{ number_format($data->Penjualan_Tunai_Transfer) }}</td>
                                                    <td>{{ number_format($data->Setoran_Tagihan_Tunai) }}</td>
                                                    <td>{{ number_format($data->Setoran_Tagihan_Non_Tunai) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Cek/Giro</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Cek/Giro</button> -->
                                        <!-- <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">S i m p a n</button> -->
                                        <!-- <button type="button" id="button_print" name="button_print" class="btn btn-primary btn-sm">Print</button> -->
                                    </div>   
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