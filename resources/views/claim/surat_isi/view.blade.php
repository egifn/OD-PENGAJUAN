@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>


@stop

@extends('layouts.admin')

@section('title')
    <title>Surat</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Surat</li>
        <li class="breadcrumb-item">Buat Surat</li>
        <li class="breadcrumb-item active">View Surat</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                    <div class="col-md-8">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        @if($format->kode_perusahaan == 'TUA')
                                            <td width="25" align="center"><img src="{{ asset('assets/img/TUA.jpg') }}" style="width: 150px; height: 80px" ></td>
                                        @elseif($format->kode_perusahaan == 'TU')
                                            <td width="25" align="center"><img src="{{ asset('assets/img/TU.jpg') }}" style="width: 100px; height: 80px" ></td>
                                        @elseif($format->kode_perusahaan == 'TA')
                                            <td width="25" align="center"><img src="{{ asset('assets/img/TA.jpg') }}" style="width: 110px; height: 80px" ></td>
                                        @elseif($format->kode_perusahaan == 'WPS')
                                            <td width="25" align="center"><img src="{{ asset('assets/img/wps.jpeg') }}" style="width: 110px; height: 80px" ></td>
                                        @elseif($format->kode_perusahaan == 'LP')
                                            <td width="25" align="center"><img src="{{ asset('assets/img/lp.jpg') }}" style="width: 80px; height: 110px" ></td>
										@endif

                                        @if($format->kode_perusahaan == 'TUA')
                                            <td width="500">
                                                <div align="center">
                                                    <b><font size="5">PT. {{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td> 
                                        @elseif($format->kode_perusahaan == 'TU')
                                            <td width="600">
                                                <div align="center">
                                                    <b><font size="5">CV. {{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td>       
                                        @elseif($format->kode_perusahaan == 'TA')
                                            <td width="590">
                                                <div align="center">
                                                    <b><font size="5">CV. {{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td> 
										@elseif($format->kode_perusahaan == 'WPS')
                                            <td width="590">
                                                <div align="center">
                                                    <b><font size="5">{{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td> 
                                        @elseif($format->kode_perusahaan == 'LP')
                                            <td width="590">
                                                <div align="center">
                                                    <b><font size="5">{{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td>     
                                        @endif

                                        
                                    </tr>
                                </table>

                                <table>
                                    <tr>
                                        <td width="800">
                                            <div align="center">
                                                <hr />
                                            </div>
                                        </td>   
                                    </tr>
                                </table>
                                <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $format->no_urut }}" required hidden> 
                                <table>
                                    <tr>
                                        <td width="600"></td>
                                        <?php $bulan; ?>
                                        @if(date('M', strtotime($format->tanggal)) == 'Jan')
                                            <?php $bulan = "Januari"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Feb')
                                            <?php $bulan = "Februari"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Mar')
                                            <?php $bulan = "Maret"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Apr')
                                            <?php $bulan = "April"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'May')
                                            <?php $bulan = "Mei"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Jun')
                                            <?php $bulan = "Juni"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Jul')
                                            <?php $bulan = "Juli"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Aug')
                                            <?php $bulan = "Agustus"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Sep')
                                            <?php $bulan = "September"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Oct')
                                            <?php $bulan = "Oktober"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Nov')
                                            <?php $bulan = "November"; ?>
                                        @elseif(date('M', strtotime($format->tanggal)) == 'Dec')
                                            <?php $bulan = "Desember"; ?>
                                        @endif

                                        @if($format->kode_perusahaan == 'TUA')
                                            <td align="right"><span>Bandung, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>        
                                        @elseif($format->kode_perusahaan == 'TU')
                                            <td align="right"><span>Bogor, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>
                                        @elseif($format->kode_perusahaan == 'TA')
                                            <td align="right"><span>Cirebon, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>              
                                        @elseif($format->kode_perusahaan == 'WPS')
                                            <td align="right"><span>Cirebon, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>
                                        @elseif($format->kode_perusahaan == 'LP')
                                            <td align="right"><span>Bogor, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>
										@endif
                                    </tr>
                                </table>

                                <tr>     
                                    <td>
                                        <table border="0" style="width: 100%;">
                                            <tbody>
                                                <tr>         
                                                    <td width="600">
                                                        <b>Kepada Yth :</b>
                                                    </td>         
                                                    <td width="200"></td>         
                                                    <td width="140"></td>       
                                                </tr>
                                                <tr>         
                                                    @if($format->kode_surat == '0669/CL-TUA/03/VII/2025')
                                                    <td width="620">
                                                        <b>PT. Smailing Tours and Travel Service</b>
                                                    </td> 
                                                    @elseif($format->kode_surat == '1406/CL-TUA/07/XI/2025')
                                                    <td width="620">
                                                        <b>PT. Smailing Tours and Travel Service</b>
                                                    </td> 
                                                    @else
                                                    <td width="600">
                                                        <b>{{ $format->kepada }}</b>
                                                    </td> 
                                                    @endif        
                                                    <td></td>         
                                                    <td></td>       
                                                </tr>
                                                <tr>         
                                                    <td width="74">
                                                        @if($format->kode_surat == '0669/CL-TUA/03/VII/2025')

                                                        @elseif($format->kode_surat == '1406/CL-TUA/07/XI/2025')

                                                        @else
                                                        <b>{{ $format->alamat_tujuan_1 }}</b>
                                                        @endif
                                                        
                                                    </td>         
                                                    <td></td>         
                                                    <td></td>       
                                                </tr>
                                                <tr>         
                                                    <td>
                                                    @if($format->kode_surat == '0669/CL-TUA/03/VII/2025')

                                                    @elseif($format->kode_surat == '1406/CL-TUA/07/XI/2025')

                                                    @else
                                                    <b>{{ $format->alamat_tujuan_2 }}</b>
                                                    @endif
                                                        
                                                    </td>         
                                                    <td></td>         
                                                    <td></td>       
                                                </tr>
                                                <tr>         
                                                    <td>
                                                    @if($format->kode_surat == '0669/CL-TUA/03/VII/2025')

                                                    @elseif($format->kode_surat == '1406/CL-TUA/07/XI/2025')

                                                    @else
                                                    <b>{{ $format->alamat_tujuan_3 }}</b>
                                                    @endif
                                                    </td>         
                                                    <td></td>         
                                                    <td></td>       
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>     
                                    <td></td>     
                                    <td></td>
                                    <br>
                                    
                                        <table border="0" style="width: 100%;">
                                            <tbody>
                                                

                                                <tr>         
                                                    <td width="100">
                                                        <b>Nomor</b>
                                                    </td>         
                                                    <td width="12">
                                                        <b>:</b>
                                                    </td>         
                                                    <td >
                                                        <b>{{ $format->kode_surat }}</b>
                                                    </td>       
                                                </tr>
                                                    
                                                <tr>         
                                                    <td>
                                                        <b>Perihal 
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </b>
                                                    </td>         
                                                    <td>
                                                        <b>:
                                                            &nbsp;&nbsp;&nbsp;
                                                        </b>
                                                    </td>         
                                                    <td>
                                                        @if($format->jenis == 'Rupiah')
                                                            <b>{{ $format->prihal }} {{ $format->prihal_isi }} 
                                                            @if($format_jumlah->jumlah == '1')
                                                                @forelse ($format_detail as $row)
                                                                    @if($row->kode_depo == '000')
                                                                        All Depo
																	@elseif($row->kode_depo == '001')
																		TUA Bandung
                                                                    @else
                                                                        {{ $format->kode_perusahaan}} {{ $row->nama_depo }}
                                                                    @endif
                                                                    
                                                                @empty

                                                                @endforelse
                                                            @elseif($format_jumlah->jumlah <= '3' )
                                                                <?php $i=1; ?>
                                                                @forelse ($format_detail as $row)
                                                                    @if( $i == $jml_depo->jumlah )
																		& @if($row->kode_depo == '001')
																			{{ $row->nama_depo }}
																		@else
																			{{ $row->kode_perusahaan}} {{ $row->nama_depo }}
																		@endif
                                                                    @elseif($i == $jml_depo->jumlah - 1)
																		@if($row->kode_depo == '001')
																			{{ $row->nama_depo }}
																		@else
																			{{ $row->kode_perusahaan}} {{ $row->nama_depo }}
																		@endif
                                                                    @else
                                                                        {{ $row->kode_perusahaan}} {{ $row->nama_depo }},
                                                                    @endif
                                                                    <?php $i++; ?>
                                                                @empty

                                                                @endforelse
                                                            @elseif($format_jumlah->jumlah >= '4' )
                                                                @if($format->kode_perusahaan == 'TUA' )
                                                                    @if($jml_perusahaan->jumlah_perusahaan == '1' )
                                                                        TUA Bandung
                                                                    @else
                                                                        All Depo
                                                                    @endif   
                                                                @else
                                                                    All Depo
                                                                @endif    
                                                            @endif 

                                                            @if($format->id_promo != '' )
                                                                (ID Promo: {{ $format->id_promo }})
                                                            @else
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            @endif 
                                                        @else
                                                            <b>{{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }})
                                                        @endif

                                                          
                                                        
                                                        </b>
                                                    </td>       
                                                </tr>
                                            </tbody>
                                        </table>
                                    
                                    <br>
                                    <tr>
                                        <table>
                                            <tbody>
                                                <tr>         
                                                    <td>
                                                        <b>Up &nbsp;</b>
                                                    </td>         
                                                    <td>
                                                        <b>: &nbsp;</b>
                                                    </td>         
                                                    <td>
                                                    @if($format->kode_surat == '0669/CL-TUA/03/VII/2025')
                                                        <b>PT. Smailing Tours and Travel Service</b>
                                                    @elseif($format->kode_surat == '1406/CL-TUA/07/XI/2025')
                                                        <b>PT. Smailing Tours and Travel Service</b>
                                                    @else
                                                        <b>{{ $format->up }}</b>
                                                    @endif
                                                    </td>       
                                                </tr>
                                            </tbody>
                                    </table>
                                    </tr>
                                    <tr>     
                                        <td></td>     
                                        <td></td>     
                                        <td></td>   
                                    </tr>

                                    <table>
                                        <tr>
                                            <td width="730">
                                                    <br>
                                                    <p>Dengan hormat,</p>
                                                    @if($format->jenis == 'Rupiah')
                                                        @if($jml_perusahaan->jumlah_perusahaan == '1' )
                                                            @if($cari_depo->kode_depo == '000' || $cari_depo->kode_depo == '111' || $cari_depo->kode_depo == '222')
                                                                @if($format->id_promo != '' )
                                                                    <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak TUA Group {{ $format->isi_2 }} </p>
                                                                @else
                                                                    <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }}, kami pihak TUA Group {{ $format->isi_2 }} </p>
                                                                @endif
                                                                
                                                            @else
                                                                @if($format->id_promo != '' )
                                                                    @if($format->kode_perusahaan == 'TUA')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak PT. {{ $format->nama_perusahaan }} {{ $format->isi_2 }} </p>
                                                                    @elseif($format->kode_perusahaan == 'TU')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak CV. {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                                    @elseif($format->kode_perusahaan == 'TA')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak CV. {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                                    @elseif($format->kode_perusahaan == 'WPS')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                                    @elseif($format->kode_perusahaan == 'LP')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
																	@endif
                                                                @else
                                                                    @if($format->kode_perusahaan == 'TUA')
                                                                        @if($format->kode_surat == '0669/CL-TUA/03/VII/2025')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak PT. {{ $format->nama_perusahaan }} hendak mengajukan Claim kepada pihak PT. Smailing Tours and Travel Service dengan perincian sebagai berikut: </p>
                                                                        @elseif($format->kode_surat == '1406/CL-TUA/07/XI/2025')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak PT. {{ $format->nama_perusahaan }} hendak mengajukan Claim kepada pihak PT. Smailing Tours and Travel Service dengan perincian sebagai berikut: </p>
                                                                        @else
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak PT. {{ $format->nama_perusahaan }} {{ $format->isi_2 }} </p>
                                                                        @endif
                                                                    @elseif($format->kode_perusahaan == 'TU')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }}, kami pihak CV. {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                                    @elseif($format->kode_perusahaan == 'TA')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }}, kami pihak CV. {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
																	@elseif($format->kode_perusahaan == 'WPS')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }}, kami pihak {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                                    @elseif($format->kode_perusahaan == 'LP')
                                                                            <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }}, kami pihak {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if($format->id_promo != '' )
                                                                <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }}), kami pihak TUA Group {{ $format->isi_2 }} </p>
                                                            @else
                                                                <p align="justify">{{ $format->isi_1}} {{ $format->prihal_isi }}, kami pihak TUA Group {{ $format->isi_2 }} </p>
                                                            @endif
                                                            
                                                        @endif
                                                    @else
                                                        @if($format->kode_perusahaan == 'TUA')
                                                                            <p align="justify">Terlampir {{ $format->prihal_isi }}, kami pihak PT. {{ $format->nama_perusahaan }} {{ $format->isi_2 }} </p>
                                                        @elseif($format->kode_perusahaan == 'TU')
                                                                            <p align="justify">Terlampir {{ $format->prihal_isi }}, kami pihak CV. {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                        @elseif($format->kode_perusahaan == 'TA')
                                                                            <p align="justify">Terlampir {{ $format->prihal_isi }}, kami pihak CV. {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
														@elseif($format->kode_perusahaan == 'WPS')
                                                                            <p align="justify">Terlampir {{ $format->prihal_isi }}, kami pihak {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                        @elseif($format->kode_perusahaan == 'LP')
                                                                            <p align="justify">Terlampir {{ $format->prihal_isi }}, kami pihak {{ $format->nama_perusahaan }} {{ $format->isi_2 }}</p>
                                                         @endif
                                                    @endif

                                                    

                                                <br>
                                            </td>
                                        </tr> 
                                    </table>

                                    <table>
                                        @if($format->jenis == 'Rupiah')

                                            @if($format_jumlah->jumlah == '1' )
                                                <table>
                                                @forelse ($format_detail as $row)
                                                    @if($row->kode_depo == '000' || $cari_depo->kode_depo == '111' || $cari_depo->kode_depo == '222')
                                                        <tr>
                                                            <td width="180"></td>
                                                            <td><b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                            <td width="50" align="center"><font size="5">:</font></td>
                                                            <td><b><font size="5">Rp. </font></b></td>
                                                            <td align="right"><b><font size="5">{{ number_format($row->amount) }}.-</font></b></td>
                                                        </tr>
													 @elseif($row->kode_depo == '001')
                                                        <tr>
                                                            <td width="180"></td>
                                                            <td><b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                            <td width="50" align="center"><font size="5">:</font></td>
                                                            <td><b><font size="5">Rp. </font></b></td>
                                                            <td align="right"><b><font size="5">{{ number_format($row->amount) }}.-</font></b></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td width="180"></td>
                                                            @if($row->nama_depo == 'Kasomalang')
                                                                <td><b><font size="5">TUA</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                                <td width="50" align="center"><font size="5">:</font></td>
                                                                <td><b><font size="5">Rp. </font></b></td>
                                                                <td align="right"><b><font size="5">{{ number_format($row->amount) }}.-</font></b></td>
                                                            @else
                                                                @if($format->kode_perusahaan == 'WPS')
                                                                    <td><b><font size="5">WPS</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                                @elseif($format->kode_perusahaan == 'LP')
                                                                    <td><b><font size="5">LP</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                                @else
                                                                    <td><b><font size="5">{{ $row->kode_perusahaan }}</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                                @endif
																<td width="50" align="center"><font size="5">:</font></td>
                                                                <td><b><font size="5">Rp. </font></b></td>
                                                                <td align="right"><b><font size="5">{{ number_format($row->amount) }}.-</font></b></td>
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    
                                                @empty
                                                    <tr>
                                                                                                    
                                                    </tr>
                                                @endforelse
                                                </table>
                                            @elseif($format_jumlah->jumlah < '4' )
                                                <table>
                                                <?php $i=1; ?>
                                                @forelse ($format_detail as $row)
                                                    <tr>
                                                        
														@if($row->kode_depo == '001')
															<td width="250"></td>
															<td><b><font size="5">{{ $row->nama_depo }}</font></b></td>
														@else
															<td width="250"></td>
															@if($format->kode_perusahaan == 'WPS')
                                                                <td><b><font size="5">WPS</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                            @elseif($format->kode_perusahaan == 'LP')
                                                                <td><b><font size="5">LP</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                            @else
                                                                <td><b><font size="5">{{ $row->kode_perusahaan }}</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
                                                            @endif
														@endif
                                                        
                                                        <td width="50" align="center"><font size="5">:</font></td>
                                                        
                                                        @if( $i == $jml_depo->jumlah )
                                                            <!-- <td><b><u><font size="5">Rp. </font></u></b></td> -->
                                                            <td align="right"><b><u><font size="5">Rp. {{ number_format($row->amount) }}.-</font></u></b></td>
                                                        @else
                                                            <!-- <td><b><font size="5">Rp. </font></b></td> -->
                                                            <td align="right"><b><font size="5">Rp. {{ number_format($row->amount) }}.-</font></b></td>
                                                        @endif
                                                        <?php $i++; ?> 
                                                    </tr>
                                                @empty
                                                    <tr>
                                                                                                  
                                                    </tr>
                                                @endforelse
                                                    <tfoot>
                                                        <td width="250"></td>
                                                        <td><b><font size="5">TOTAL</font></b></td>
                                                        <td width="50" align="center"><font size="5">:</font></td>
                                                        <!-- <td><b><font size="5">Rp. </font></b></td> -->
                                                        <td align="right"><b><font size="5">Rp. {{ number_format($format_total->amount) }}.-</font></b></td>
                                                    </tfoot>
                                                </table>
                                            @elseif($format_jumlah->jumlah >= '4' )
                                                <table>
                                                    <tr>
                                                        <td width="250"></td>
                                                        @if($format->kode_perusahaan == 'TUA' )
                                                            @if($jml_perusahaan->jumlah_perusahaan == '1' )
                                                                <td><b><font size="5">TUA Bandung</font></b></td>
                                                            @else
                                                                <td><b><font size="5">All Depo</font></b></td>
                                                            @endif        
                                                             
                                                        @else
                                                            <td><b><font size="5">All Depo</font></b></td>       
                                                        @endif   
                                                        <td width="50" align="center"><font size="5">:</font></td>
                                                        <td><b><font size="5">Rp. </font></b></td>
                                                        <td align="right"><b><font size="5">{{ number_format($format_total->amount) }}.-</font></b></td>
                                                    </tr>
                                                </table>
                                            @endif 

                                        @else

                                            
                                                <table border='1' width='500' style="border-color: black; margin-left: 20%;"">
                                                <thead>
                                                        <tr  align="center">
                                                            <th ><font size="3">Customer Name</font></th>
                                                            @forelse($header_sku as $header)
                                                                <th align="center"><font size="3">{{ $header->nama_produk }}</font></th>
                                                            @empty

                                                            @endforelse
                                                            <!-- <th align="center"><font size="3">AQUA 600ML</font></th>
                                                            <th align="center"><font size="3">AQUA 1500ML</font></th> 
															<th align="center"><font size="3">Product Name</font></th> -->
                                                            <th align="center"><font size="3">Total Box</font></th>
                                                        </tr>
                                                </thead>
                                                @forelse ($format_detail_box as $row)
                                                    <tbody>
                                                        <tr>
                                                            <?php $tot=0; ?>
                                                            <td align="center"><font size="3">{{ $row->kode_depo }}</font></td>
                                                            @forelse($header_sku as $header)
                                                                <td align="center"><font size="3">{{ number_format($header->amount) }}</font></td>
                                                                @if($header->amount == '0' )
                                                                    <?php $tot += $header->amount ?>
                                                                @elseif($header->amount > '0' )
                                                                    <?php $tot += $header->amount  ?>
                                                                @endif 
																<td align="center"><font size="3">{{ number_format($tot) }}</font></td>
                                                            @empty

                                                            @endforelse
                                                            <!--  <td align="center"><font size="3"></font></td>
                                                            <td align="center"><font size="3"></font></td> -->
                                                            @if($row->amount_2 == '0' )
                                                                 <td align="center"><font size="3"><?php echo number_format($tot) ?></font></td>
                                                            @elseif($row->amount_2 > '0' )
                                                                 <td align="center"><font size="3"><?php echo number_format($tot) ?></font></td>
                                                            @endif 
                                                            <?php $tot=0; ?>
                                                        </tr>                
                                                    </tbody>
                                                @empty
                                                    <tr>
                                                                                                    
                                                    </tr>
                                                @endforelse
													<tfoot hidden>
                                                        <tr>
                                                            
                                                            <td colspan="{{ $total_sku_foot->jml + 1 }}" align="center"><font size="3"><b>TOTAL<b></font></td>

                                                            @if($format_detail_box_total_rupiah->amount_2 == '0')
                                                                <td colspan="1" align="center"><font size="3"><b>{{ number_format($format_detail_box_total->total) }}</b></font></td>
                                                            @else
                                                                <td colspan="1" align="center"><font size="3"><b>Rp. {{ number_format($format_detail_box_total_rupiah->total) }},-</b></font></td>
                                                            @endif
                                                        </tr>
													</tfoot>
                                                </table>
                                            
                                            

                                        @endif

                                                             
       
                                    </table>
                                    <br>
                                    <table>
                                        <tr>
                                            <td width="790">
                                                <!-- <span style="font-size: x-small;"> -->
                                                <p align="justify">Kami juga lampirkan {{ $format->dokumen }} lainnya.<br>
                                                {{ $format->penutup }}</p>
                                                <!-- </span> -->
                                            </td>
                                        </tr>
                                    </table>

                                    <br>
                                    <br>
                                    <table>
                                        @if($format->menyetujui_ext == '' && $format->menyetujui_ext2 == '' )
                                        <tr>
                                            <td width="10"></td>
                                            <td align="center">
                                                <span><b>Hormat Kami,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>{{ $format->name }}</b></span>
                                                <br>
                                                <span><b>Klaim Pusat</b></span>
                                            </td>

                                            <td width="430"></td>

                                            <td align="center">
                                                <span><b>Menyetujui,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>Jeisni La Sesa P</b></span>
                                                <br>
                                                <span><b>Koordinator Klaim Pusat</b></span>
                                            </td>
                                        </tr> 
                                        @elseif($format->menyetujui_ext != '' && $format->menyetujui_ext2 == '' )
                                        <tr>
                                            <td width="10"></td>
                                            <td align="center">
                                                <span><b>Hormat Kami,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>{{ $format->name }}</b></span>
                                                <br>
                                                <span><b>Klaim Pusat</b></span>
                                            </td>

                                            <td width="430" align="center">
                                                <span><b>Mengetahui,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>Jeisni La Sesa P</b></span>
                                                <br>
                                                <span><b>Koordinator Klaim Pusat</b></span>
                                            </td>

                                            <td align="center">
                                                <span><b>Menyetujui,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>{{ $format->menyetujui_ext }}</b></span>
                                                <br>
                                                <span><b>{{ $format->sebagai_ext }}</b></span>
                                            </td>
                                        </tr>
                                        @elseif($format->menyetujui_ext != '' && $format->menyetujui_ext2 != '' )
                                        <tr>
                                            <td width="10"></td>
                                            <td align="center">
                                                <span><b>Hormat Kami,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>{{ $format->name }}</b></span>
                                                <br>
                                                <span><b>Klaim Pusat</b></span>
                                            </td>

                                            <td width="350" align="center">
                                                <span><b>Mengetahui,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>Jeisni La Sesa P</b></span>
                                                <br>
                                                <span><b>Koordinator Klaim Pusat</b></span>
                                            </td>

                                            <td align="center">
                                                <span><b>Menyetujui,</b></span><br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span><b>{{ $format->menyetujui_ext }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $format->menyetujui_ext2 }}</b></span>
                                                <br>
                                                <span><b>{{ $format->sebagai_ext }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $format->sebagai_ext2 }}</b></span>
                                            </td>

                                            
                                        </tr>                        
                                        @endif 
                                    </table>


                                </tr>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-body">
                                <br>
                                <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $format->no_urut }}" required hidden> 
                                <div class="form-group" align="center">
                                    <a href="{{ route('isi_surat/pdf.pdf', $format->no_urut) }}" class="btn btn-primary btn-lm" target="_blank">C e t a k</a>
                                </div>
                                <br>
                                <div class="form-group" align="center">
                                    <a href="{{ route('isi_surat/update.update', $format->no_urut) }}" class="btn btn-warning btn-lm">E d i t</a>
                                </div>
                                <br>
                                <div class="form-group" align="center">
                                    <button type="submit" class="btn btn-success btn-lm" onclick="goBack()">K e m b a l i</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>

               
            </div>
        </div>
    </div>
</main>

@endsection

