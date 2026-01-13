
@extends('layouts.admin')

@section('title')
    <title>Report</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Gudang Out</li>
        <li class="breadcrumb-item active">Data Stok</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Data Stok</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('check_control_Report_gudang_out/cari.cari') }}" method="get">
                                    <div class="input-group mb-3 col-md-6 float-right"> 
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                            <option value="">Perusahaan</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                        &nbsp;
                                        <select name="kode_depo" id="kode_depo" class="form-control" required>
                                            <option value="">Depo</option>
                                        </select>
                                        &nbsp;
                                       
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}" hidden>
                                        &nbsp;
                                        <button class="btn btn-primary" type="submit">C a r i</button>
                                    </div>    
                                </form>

                                <div class="table-responsive">
                                        
                                    @if($k_depo->kode_depo == '337') <!-- BOGOR -->

                                    <div style="border:1px white;width:250%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">

                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="3" style="text-align: center;">Zona A Gallon Jugrack</th>
                                                    <th colspan="2" style="text-align: center;">Zona B Gallon Jugrack</th>
                                                    <th colspan="3" style="text-align: center;">Zona C Gallon Lasah</th>
                                                    <th colspan="4" style="text-align: center;">Zona D Gallon BS</th>  
                                                    <th rowspan="2" style="vertical-align: middle;" hidden>#</th>   
                                                    <tr>
                                                        <th>Blok A1 Gallon Jugrack</th>
                                                        <th>Blok A2 Gallon Jugrack </th>
                                                        <th>Blok A3 Gallon Jugrack </th>
                                                        <th>Blok B1 Gallon Jugrack </th>
                                                        <th>Blok B2 Gallon Jugrack </th>
                                                        <th>Blok C1 Gallon Lasah</th>
                                                        <th>Blok C2 Gallon Lasah</th>
                                                        <th>Blok C3 Gallon Lasah</th>
                                                        <th>Blok D Gallon BS Ekspedisi</th>
                                                        <th>Blok D Gallon BS Tolakan</th>
                                                        <th>Blok D Gallon BS Sales</th>
                                                        <th>Blok D Gallon BS Gudang</th>
                                                    </tr>  
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A1 }}</td>
                                                    <td align="right">{{ $val->A2 }}</td>
                                                    <td align="right">{{ $val->A3 }}</td>
                                                    <td align="right">{{ $val->B1 }}</td>
                                                    <td align="right">{{ $val->B2 }}</td>
                                                    <td align="right">{{ $val->C6 }}</td>
                                                    <td align="right">{{ $val->C7 }}</td>
                                                    <td align="right">{{ $val->C8 }}</td>
                                                    <td align="right">{{ $val->D4 }}</td>
                                                    <td align="right">{{ $val->D5 }}</td>
                                                    <td align="right">{{ $val->D6 }}</td>
                                                    <td align="right">{{ $val->D7 }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="20" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                    </div>
                                   
                                    @elseif($k_depo->kode_depo == '901') <!-- PARUNG -->

                                    <div style="border:1px white;width:1500%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="17" style="text-align: center;">Zona A Gallon Jugrack</th>
                                                    <th colspan="10" style="text-align: center;">Zona B Gallon Jugrack</th>
                                                    <th colspan="9" style="text-align: center;">Zona B Gallon Lasah</th>
                                                    <th colspan="5" style="text-align: center;">Zona C Gallon Jugrack</th>
                                                    <th colspan="23" style="text-align: center;">Zona C Gallon Lasah</th>
                                                    <th colspan="3" style="text-align: center;">Zona D Gallon Lasah</th>  
                                                    <th colspan="4" style="text-align: center;">Zona E Gallon BS</th>   
                                                    <tr>
                                                        <th>Blok A1 Gallon Jugrack</th>
                                                        <th>Blok A2 Gallon Jugrack </th>
                                                        <th>Blok A3 Gallon Jugrack </th>
                                                        <th>Blok A4 Gallon Jugrack</th>
                                                        <th>Blok A5 Gallon Jugrack </th>
                                                        <th>Blok A6 Gallon Jugrack </th>
                                                        <th>Blok A7 Gallon Jugrack </th>
                                                        <th>Blok A8 Gallon Jugrack </th>
                                                        <th>Blok A9 Gallon Jugrack </th>
                                                        <th>Blok A10 Gallon Jugrack </th>
                                                        <th>Blok A11 Gallon Jugrack </th>
                                                        <th>Blok A12 Gallon Jugrack </th>
                                                        <th>Blok A13 Gallon Jugrack </th>
                                                        <th>Blok A14 Gallon Jugrack </th>
                                                        <th>Blok A15 Gallon Jugrack </th>
                                                        <th>Blok A16 Gallon Jugrack </th>
                                                        <th>Blok A17 Gallon Jugrack </th>

                                                        <th>Blok B1 Gallon Jugrack </th>
                                                        <th>Blok B2 Gallon Jugrack </th>
                                                        <th>Blok B3 Gallon Jugrack </th>
                                                        <th>Blok B4 Gallon Jugrack </th>
                                                        <th>Blok B5 Gallon Jugrack </th>
                                                        <th>Blok B6 Gallon Jugrack </th>
                                                        <th>Blok B7 Gallon Jugrack </th>
                                                        <th>Blok B8 Gallon Jugrack </th>
                                                        <th>Blok B9 Gallon Jugrack </th>
                                                        <th>Blok B10 Gallon Jugrack </th>

                                                        <th>Blok B1 Gallon Lasah </th>
                                                        <th>Blok B2 Gallon Lasah </th>
                                                        <th>Blok B3 Gallon Lasah </th>
                                                        <th>Blok B4 Gallon Lasah </th>
                                                        <th>Blok B5 Gallon Lasah </th>
                                                        <th>Blok B6 Gallon Lasah </th>
                                                        <th>Blok B7 Gallon Lasah </th>
                                                        <th>Blok B8 Gallon Lasah </th>
                                                        <th>Blok B9 Gallon Lasah </th>

                                                        <th>Blok C1 Gallon Jugrack</th>
                                                        <th>Blok C2 Gallon Jugrack</th>
                                                        <th>Blok C3 Gallon Jugrack</th>
                                                        <th>Blok C4 Gallon Jugrack</th>
                                                        <th>Blok C5 Gallon Jugrack</th>

                                                        <th>Blok C1 Gallon Lasah</th>
                                                        <th>Blok C2 Gallon Lasah</th>
                                                        <th>Blok C3 Gallon Lasah</th>
                                                        <th>Blok C4 Gallon Lasah</th>
                                                        <th>Blok C5 Gallon Lasah</th>
                                                        <th>Blok C6 Gallon Lasah</th>
                                                        <th>Blok C7 Gallon Lasah</th>
                                                        <th>Blok C8 Gallon Lasah</th>
                                                        <th>Blok C9 Gallon Lasah</th>
                                                        <th>Blok C10 Gallon Lasah</th>
                                                        <th>Blok C11 Gallon Lasah</th>
                                                        <th>Blok C12 Gallon Lasah</th>
                                                        <th>Blok C13 Gallon Lasah</th>
                                                        <th>Blok C14 Gallon Lasah</th>
                                                        <th>Blok C15 Gallon Lasah</th>
                                                        <th>Blok C16 Gallon Lasah</th>
                                                        <th>Blok C17 Gallon Lasah</th>
                                                        <th>Blok C18 Gallon Lasah</th>
                                                        <th>Blok C19 Gallon Lasah</th>
                                                        <th>Blok C20 Gallon Lasah</th>
                                                        <th>Blok C21 Gallon Lasah</th>
                                                        <th>Blok C22 Gallon Lasah</th>
                                                        <th>Blok C23 Gallon Lasah</th>

                                                        <th>Blok D1 Gallon Lasah</th>
                                                        <th>Blok D2 Gallon Lasah</th>
                                                        <th>Blok D3 Gallon Lasah</th>

                                                        <th>Blok E Gallon BS Ekspedisi</th>
                                                        <th>Blok E Gallon BS Tolakan</th>
                                                        <th>Blok E Gallon BS Sales</th>
                                                        <th>Blok E Gallon BS Gudang</th>
                                                    </tr>  
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A1 }}</td>
                                                    <td align="right">{{ $val->A2 }}</td>
                                                    <td align="right">{{ $val->A3 }}</td>
                                                    <td align="right">{{ $val->A4 }}</td>
                                                    <td align="right">{{ $val->A5 }}</td>
                                                    <td align="right">{{ $val->A6 }}</td>
                                                    <td align="right">{{ $val->A7 }}</td>
                                                    <td align="right">{{ $val->A8 }}</td>
                                                    <td align="right">{{ $val->A9 }}</td>
                                                    <td align="right">{{ $val->A10 }}</td>
                                                    <td align="right">{{ $val->A11 }}</td>
                                                    <td align="right">{{ $val->A12 }}</td>
                                                    <td align="right">{{ $val->A13 }}</td>
                                                    <td align="right">{{ $val->A14 }}</td>
                                                    <td align="right">{{ $val->A15 }}</td>
                                                    <td align="right">{{ $val->A16 }}</td>
                                                    <td align="right">{{ $val->A17 }}</td>
                                                    
                                                    <td align="right">{{ $val->B1 }}</td>
                                                    <td align="right">{{ $val->B2 }}</td>
                                                    <td align="right">{{ $val->B3 }}</td>
                                                    <td align="right">{{ $val->B4 }}</td>
                                                    <td align="right">{{ $val->B5 }}</td>
                                                    <td align="right">{{ $val->B6 }}</td>
                                                    <td align="right">{{ $val->B7 }}</td>
                                                    <td align="right">{{ $val->B8 }}</td>
                                                    <td align="right">{{ $val->B8 }}</td>
                                                    <td align="right">{{ $val->B10 }}</td>

                                                    <td align="right">{{ $val->B11 }}</td>
                                                    <td align="right">{{ $val->B12 }}</td>
                                                    <td align="right">{{ $val->B13 }}</td>
                                                    <td align="right">{{ $val->B14 }}</td>
                                                    <td align="right">{{ $val->B15 }}</td>
                                                    <td align="right">{{ $val->B16 }}</td>
                                                    <td align="right">{{ $val->B17 }}</td>
                                                    <td align="right">{{ $val->B18 }}</td>
                                                    <td align="right">{{ $val->B19 }}</td>

                                                    <td align="right">{{ $val->C1 }}</td>
                                                    <td align="right">{{ $val->C2 }}</td>
                                                    <td align="right">{{ $val->C3 }}</td>
                                                    <td align="right">{{ $val->C4 }}</td>
                                                    <td align="right">{{ $val->C5 }}</td>

                                                    <td align="right">{{ $val->C6 }}</td>
                                                    <td align="right">{{ $val->C7 }}</td>
                                                    <td align="right">{{ $val->C8 }}</td>
                                                    <td align="right">{{ $val->C9 }}</td>
                                                    <td align="right">{{ $val->C10 }}</td>
                                                    <td align="right">{{ $val->C11 }}</td>
                                                    <td align="right">{{ $val->C12 }}</td>
                                                    <td align="right">{{ $val->C13 }}</td>
                                                    <td align="right">{{ $val->C14 }}</td>
                                                    <td align="right">{{ $val->C15 }}</td>
                                                    <td align="right">{{ $val->C15 }}</td>
                                                    <td align="right">{{ $val->C17 }}</td>
                                                    <td align="right">{{ $val->C18 }}</td>
                                                    <td align="right">{{ $val->C19 }}</td>
                                                    <td align="right">{{ $val->C20 }}</td>
                                                    <td align="right">{{ $val->C21 }}</td>
                                                    <td align="right">{{ $val->C22 }}</td>
                                                    <td align="right">{{ $val->C23 }}</td>
                                                    <td align="right">{{ $val->C24 }}</td>
                                                    <td align="right">{{ $val->C25 }}</td>
                                                    <td align="right">{{ $val->C26 }}</td>
                                                    <td align="right">{{ $val->C27 }}</td>
                                                    <td align="right">{{ $val->C28 }}</td>

                                                    <td align="right">{{ $val->D1 }}</td>
                                                    <td align="right">{{ $val->D2 }}</td>
                                                    <td align="right">{{ $val->D3 }}</td>
                                                    <td align="right">{{ $val->E1 }}</td>
                                                    <td align="right">{{ $val->E2 }}</td>
                                                    <td align="right">{{ $val->E3 }}</td>
                                                    <td align="right">{{ $val->E4 }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                    </div>

                                    @elseif($k_depo->kode_depo == '342') <!-- CITEUREUP -->     
                                    
                                    <div style="border:1px white;width:250%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">

                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="3" style="text-align: center;">Zona A Gallon Jugrack</th>
                                                    <th colspan="2" style="text-align: center;">Zona B Gallon Jugrack</th>
                                                    <th colspan="2" style="text-align: center;">Zona C Gallon Lasah</th>
                                                    <th colspan="4" style="text-align: center;">Zona D Gallon BS</th>  
                                                    <th rowspan="2" style="vertical-align: middle;" hidden>#</th>   
                                                    <tr>
                                                        <th>Blok A1 Gallon Jugrack</th>
                                                        <th>Blok A2 Gallon Jugrack </th>
                                                        <th>Blok A3 Gallon Jugrack </th>
                                                        <th>Blok B1 Gallon Jugrack </th>
                                                        <th>Blok B2 Gallon Jugrack </th>
                                                        <th>Blok C1 Gallon Lasah</th>
                                                        <th>Blok C2 Gallon Lasah</th>
                                                        <th>Blok D Gallon BS Ekspedisi</th>
                                                        <th>Blok D Gallon BS Tolakan</th>
                                                        <th>Blok D Gallon BS Sales</th>
                                                        <th>Blok D Gallon BS Gudang</th>
                                                    </tr>  
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A1 }}</td>
                                                    <td align="right">{{ $val->A2 }}</td>
                                                    <td align="right">{{ $val->A3 }}</td>
                                                    <td align="right">{{ $val->B1 }}</td>
                                                    <td align="right">{{ $val->B2 }}</td>
                                                    <td align="right">{{ $val->C6 }}</td>
                                                    <td align="right">{{ $val->C7 }}</td>
                                                    <td align="right">{{ $val->D4 }}</td>
                                                    <td align="right">{{ $val->D5 }}</td>
                                                    <td align="right">{{ $val->D6 }}</td>
                                                    <td align="right">{{ $val->D7 }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                    </div>
									
									@elseif($k_depo->kode_depo == '902') <!-- METRO -->     
                                    
                                    <div style="border:1px white;width:300%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">

                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="5" style="text-align: center;">Zona A Gallon Lasah</th>
                                                    <th colspan="5" style="text-align: center;">Zona B Gallon Lasah</th>
                                                    <th colspan="4" style="text-align: center;">Zona C Gallon Lasah</th>
                                                    <th colspan="5" style="text-align: center;">Zona D Gallon Kosong & BS Gallon</th>
                                                    <th colspan="1" style="text-align: center;">Zona E Intransit</th>  
                                                    <th rowspan="2" style="vertical-align: middle;" hidden>#</th>   
                                                    <tr>
                                                        <th>A1</th>
                                                        <th>A2</th>
                                                        <th>A3</th>
                                                        <th>A4</th>
                                                        <th>A5</th>
                                                        <th>B1</th>
                                                        <th>B2</th>
                                                        <th>B3</th>
                                                        <th>B4</th>
                                                        <th>B5</th>
                                                        <th>C1</th>
                                                        <th>C2</th>
                                                        <th>C3</th>
                                                        <th>C4</th>
                                                        <th>D1 Gallon Kosong</th>
                                                        <th>D2 BS Expedisi</th>
                                                        <th>D3 BS Tolakan</th>
                                                        <th>D4 BS Buffer Stock</th>
                                                        <th>D5 BS Sales</th>
                                                        <th>E1 Expedisi</th>
                                                    </tr>  
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A23 }}</td>
                                                    <td align="right">{{ $val->A24 }}</td>
                                                    <td align="right">{{ $val->A25 }}</td>
                                                    <td align="right">{{ $val->A26 }}</td>
                                                    <td align="right">{{ $val->A27 }}</td>
                                                    <td align="right">{{ $val->B20 }}</td>
                                                    <td align="right">{{ $val->B21 }}</td>
                                                    <td align="right">{{ $val->B22 }}</td>
                                                    <td align="right">{{ $val->B23 }}</td>
                                                    <td align="right">{{ $val->B24 }}</td>
                                                    <td align="right">{{ $val->C31 }}</td>
                                                    <td align="right">{{ $val->C32 }}</td>
                                                    <td align="right">{{ $val->C33 }}</td>
                                                    <td align="right">{{ $val->C34 }}</td>
                                                    <td align="right">{{ $val->D8 }}</td>
                                                    <td align="right">{{ $val->D9 }}</td>
                                                    <td align="right">{{ $val->D10 }}</td>
                                                    <td align="right">{{ $val->D11 }}</td>
                                                    <td align="right">{{ $val->D12 }}</td>
                                                    <td align="right">{{ $val->E5 }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                        </div>
									
									
									@elseif($k_depo->kode_depo == '343') <!-- PADALARANG -->

                                        <div style="border:1px white;width:250%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">

                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="4" style="text-align: center;">Zona A Gallon Lasah</th>
                                                    <th colspan="5" style="text-align: center;">Zona B Gallon Kosong & BS Gallon</th> 
													<th colspan="1" style="text-align: center;">Zona C Gallon Kosong</th>
													<th colspan="1" style="text-align: center;">Zona D Intransit </th>													
                                                    <th rowspan="2" style="vertical-align: middle;" hidden>#</th>   
                                                    <tr>
                                                        <th>A1</th>
                                                        <th>A2</th>
                                                        <th>A3</th>
                                                        <th>A4</th>
                                                        <th>B1 Gallon Kosong</th>
                                                        <th>B2 BS Expedisi</th>
                                                        <th>B3 BS Tolakan</th>
                                                        <th>B4 BS Buffer Stock</th>
                                                        <th>B5 BS Sales</th>
														<th>C1 Gallon Kosong</th>
                                                        <th>D1 Expedisi</th>
                                                    </tr>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A23 }}</td>
                                                    <td align="right">{{ $val->A24 }}</td>
                                                    <td align="right">{{ $val->A25 }}</td>
                                                    <td align="right">{{ $val->A26 }}</td>
                                                    <td align="right">{{ $val->B25 }}</td>
                                                    <td align="right">{{ $val->B26 }}</td>
                                                    <td align="right">{{ $val->B27 }}</td>
                                                    <td align="right">{{ $val->B28 }}</td>
                                                    <td align="right">{{ $val->B29 }}</td>
													<td align="right">{{ $val->C35 }}</td>
													<td align="right">{{ $val->D13 }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                        </div>
									
									@elseif($k_depo->kode_depo == '915') <!-- SENTUL -->

                                        <div style="border:1px white;width:150%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">

                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="2" style="text-align: center;">SENTUL GUDANG 1</th>
                                                    <th colspan="4" style="text-align: center;">SENTUL GUDANG 2</th>
                                                    <th colspan="5" style="text-align: center;">SENTUL GUDANG UP</th> 
                                                    <th rowspan="2" style="vertical-align: middle;" hidden>#</th>   
                                                    <tr>
                                                        <th>STL G1-1</th>
                                                        <th>STL G1-2</th>
                                                        <th>STL G2-1</th>
                                                        <th>STL G2-2</th>
                                                        <th>STL G2-3</th>
                                                        <th>STL G2-4</th>
                                                        <th>STL G-BS Ekspedisi</th>
                                                        <th>STL G-BS Tolakan</th>
                                                        <th>STL G-BS Sales</th>
                                                        <th>STL G-BS Gudang</th>
                                                        <th>STL G-Up</th>
                                                    </tr> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A915A }}</td>
                                                    <td align="right">{{ $val->A915B }}</td>
                                                    <td align="right">{{ $val->A915C }}</td>
                                                    <td align="right">{{ $val->A915D }}</td>
                                                    <td align="right">{{ $val->A915E }}</td>
                                                    <td align="right">{{ $val->A915F }}</td>
                                                    <td align="right">{{ $val->A915G }}</td>
                                                    <td align="right">{{ $val->A915H }}</td>
                                                    <td align="right">{{ $val->A915I }}</td>
                                                    <td align="right">{{ $val->A915J }}</td>
                                                    <td align="right">{{ $val->A915K }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                        </div>
									@elseif($k_depo->kode_depo == '034-W01') <!-- Pool Kasomalang -->

                                        <div style="border:1px white;width:100%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">

                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="3" style="text-align: center;">Parkiran Kasomalang</th> 
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Total</th>   
                                                    <tr>
                                                        <th>BS Galon Layak</th>
                                                        <th>BS Galon Sortir</th>
                                                        <th>BS Galon Reject</th>
                                                        
                                                    </tr>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A034W01A }}</td>
                                                    <td align="right">{{ $val->A034W01B }}</td>
                                                    <td align="right">{{ $val->A034W01C }}</td>
                                                    <td align="right"><b>{{ number_format($val->A034W01A + $val->A034W01B + $val->A034W01C) }}</b></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                        </div>
                                    @elseif($k_depo->kode_depo == '034-W02') <!-- Pool Dewan -->

                                        <div style="border:1px white;width:100%;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">

                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Id</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Product Name</th>
                                                    <th colspan="3" style="text-align: center;">Parkiran Dewan</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Total</th>   
                                                    <tr>
                                                        <th>BS Galon Layak</th>
                                                        <th>BS Galon Sortir</th>
                                                        <th>BS Galon Reject</th>
                                                        
                                                    </tr>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $no = 1; @endphp
                                            @forelse ($report as $val)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $val->kode_produk }}</td>
                                                    <td>{{ $val->nama_produk }}</td>
                                                    <td align="right">{{ $val->A034W02A }}</td>
                                                    <td align="right">{{ $val->A034W02B }}</td>
                                                    <td align="right">{{ $val->A034W02C }}</td>
                                                    <td align="right"><b>{{ number_format($val->A034W02A + $val->A034W02B + $val->A034W02C) }}</b></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <th colspan="2" style="text-align: center;"></th>
                                                <th colspan="1" style="text-align: right;"></th>
                                                <th colspan="9" style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            </tfoot>
                                        </table>
                                        </div>
									
                                    @endif
                                            
                                        
                                </div>
                                <div class="row"> 
                                    

                                </div>
                                
                                <div class="row">
                                    <div class="col-md-10 mb-2" hidden>
                                        
                                        <a href="#" target="_blank" class="btn btn-warning btn-sm" hidden><b>P r i n t</b></a>  

                                        <a href="#" class="btn btn-success btn-sm">Approved</a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" class="btn btn-warning btn-sm">Pending</a>
                                    </div> 

                                    <div class="col-md-2 mb-2" hidden>
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">Back</button>
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

@section('js')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        
        $(document).ready(function() {
            //INISIASI DATERANGEPICKER
            $('#tanggal').daterangepicker({
               
            })
        })

        $(function(){
            $('#kode_perusahaan').change(function(){
                var perusahaan_id = $(this).val();
                if(perusahaan_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo_stok_gudang_out?perusahaan_id="+perusahaan_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#kode_depo").empty();
                                $("#kode_depo").append('<option value="">Select</option>');
                                $.each(res,function(nama,kode){
                                    $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#kode_depo").empty();
                            }
                        }
                    });
                }else{
                    $("#kode_depo").empty();
                }
            });
        });

        function goBack() {
            window.history.back();
        }

    </script>

@endsection


