<html>
<head>
<title>Surat</title>
</head>

<body>
	<br>
	<table>
		<tr>
		
			@if($format->kode_perusahaan == 'TUA')
				<td width="20"></td>
				<td width="25" align="center"><img src="{{ public_path('TUA.jpg') }}" style="width: 150px; height: 80px" ></td>
			@elseif($format->kode_perusahaan == 'TU')
				<td width="20"></td>
				<td width="25" align="center"><img src="{{ public_path('TU.jpg') }}" style="width: 100px; height: 80px" ></td>
			@elseif($format->kode_perusahaan == 'TA')
				<td width="20"></td>
				<td width="25" align="center"><img src="{{ public_path('TA.jpg') }}" style="width: 100px; height: 80px" ></td>
			@elseif($format->kode_perusahaan == 'WPS')
				<td ></td>
				<td align="center"><img src="{{ public_path('wps.jpeg') }}" style="width: 160px; height: 130px" ></td>
			@elseif($format->kode_perusahaan == 'LP')
				<td ></td>
				<td align="center"><img src="{{ public_path('lp.jpeg') }}" style="width: 120px; height: 140px" ></td>
			@endif
			
			@if($format->kode_perusahaan == 'TUA')
                                            <td width="350">
                                                <div align="center">
                                                    <b><font size="5">PT. {{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td> 
            @elseif($format->kode_perusahaan == 'TU')
                                            <td width="400">
                                                <div align="center">
                                                    <b><font size="5">CV. {{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td>       
            @elseif($format->kode_perusahaan == 'TA')
                                            <td width="390">
                                                <div align="center">
                                                    <b><font size="5">CV. {{ $format->nama_perusahaan }}</font></b><br>
                                                    <b>{{ $format->header_judul }}</b><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td> 
			@elseif($format->kode_perusahaan == 'WPS')
                                            <td width="360">
                                                <div align="center">
                                                    <b><font size="5">{{ $format->nama_perusahaan }}</font></b><br>
                                                    <span style="font-size: smaller;">{{ $format->header_judul }}</span><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td> 
			@elseif($format->kode_perusahaan == 'LP')
                                            <td width="360">
                                                <div align="center">
                                                    <b><font size="5">{{ $format->nama_perusahaan }}</font></b><br>
                                                    <span style="font-size: smaller;">{{ $format->header_judul }}</span><br>
                                                    <b>{{ $format->header_alamat }}</b>
                                              </div>
                                            </td>  										
            @endif
		</tr>
	</table>
	<table>
		<tr>
			@if($format->kode_perusahaan == 'WPS')
			<td width="15"></td>
			@elseif($format->kode_perusahaan == 'LP')
			<td width="15"></td>
			@else
			<td width="1																																																																		5"></td>
			@endif
			
			<td width="520">
				@if($format->kode_perusahaan == 'WPS')
					<div align="center" style="margin-top: -3%;">
						<hr />
					</div>
				@elseif($format->kode_perusahaan == 'LP')
					<div align="center" style="margin-top: -3%;">
						<hr />
					</div>
				@else
					<div align="center">
						<hr />
					</div>
				@endif
			</td>     
		</tr>
	</table>

	<table>
		<tr>
			<td></td>
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
           		<td align="right" width="517"><span>Bandung, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>          
            @elseif($format->kode_perusahaan == 'TU')
            	<td align="right" width="517"><span>Bogor, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>
            @elseif($format->kode_perusahaan == 'TA')
            	<td align="right" width="517"><span>Cirebon, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>            	
            @elseif($format->kode_perusahaan == 'WPS')
			    <td align="right" width="517"><span>Cirebon, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>  
			@elseif($format->kode_perusahaan == 'LP')
			    <td align="right" width="517"><span>Bogor, {{ date('d', strtotime($format->tanggal)) }} <?php echo $bulan; ?> {{ date('Y', strtotime($format->tanggal)) }}</span></td>  
			@endif
		</tr>
	</table>

	
		
				<table border="0" style="width: 239px;">
					<tbody>
						<tr>    
							<td width="15">
							<td width="74">
								<b>Kepada Yth :</b>
							</td>         
							<td width="200"></td>         
							<td width="140"></td>       
						</tr>
						<tr>  
							<td width="15">
							<td width="220">
								@if($format->kode_surat == '0669/CL-TUA/03/VII/2025')
									<b>PT. Smailing Tours and Travel Service</b>
								@elseif($format->kode_surat == '1406/CL-TUA/07/XI/2025')
									<b>PT. Smailing Tours and Travel Service</b>
								@else
									<b>{{ $format->kepada }}</b>
								@endif
							</td>         
							<td></td>         
							<td></td>       
						</tr>
						<tr> 
							<td width="15">
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
							<td width="15">
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
							<td width="15">
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
			  
		
		<br>
		
			
			<table>
				<tbody>
					<tr>
						<td width="15">
						<td width="50">
							<b>Nomor</b>
						</td>         
						<td width="8">
							<b>:</b>
						</td>         
						<td width="400">
							<b>{{ $format->kode_surat }}</b>
						</td>       
					</tr>
						
					<tr> 
						<td width="15">
						<td>
							<b>Perihal 
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							</b>
						</td>         
						<td>
							<b>:
							&nbsp;&nbsp;&nbsp;&nbsp;
							

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

	                            @endif     
	                            
	                            </b>
							@else
								<b>{{ $format->prihal_isi }} (ID Promo: {{ $format->id_promo }})
							@endif

							
						</td> 
						<td width="8">
						</td>      
					</tr>
				</tbody>
			</table>
			
		
		<br>
		
			
			<table>
					<tbody>
						<tr> 
							<td width="15">
							<td>
								<b>Up</b>
							</td>         
							<td>
								<b>:</b>
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
				
		
		
		
		
		<table>
			<tr>
				<td width="15">
				<td width="480">
					
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
	                	@if($row->kode_depo == '000' || $row->kode_depo == '111' || $row->kode_depo == '222')
	                		<tr>
		                        <td width="100">&nbsp;</td>
		                        <td width="150"><b><font size="5">{{ $row->nama_depo }}</font></b></td>
		                        <td width="50" align="center"><font size="5">:</font></td>
		                        <td><b><font size="5">Rp. </font></b></td>
		                       	<td align="right"><b><font size="5">{{ number_format($row->amount) }}.-</font></b></td>
		                    </tr>
						@elseif($row->kode_depo == '001')
                            <tr>
                                <td width="100">&nbsp;</td>
		                        <td width="150"><b><font size="5">{{ $row->nama_depo }}</font></b></td>
		                        <td width="50" align="center"><font size="5">:</font></td>
		                        <td><b><font size="5">Rp. </font></b></td>
		                       	<td align="right"><b><font size="5">{{ number_format($row->amount) }}.-</font></b></td>
                            </tr>
						
	                	@else
	                		<tr>
								<td width="100">&nbsp;</td>
								@if($row->nama_depo == 'Kasomalang')
									<td width="150"><b><font size="5">TUA</b></font> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
									<td width="50" align="center"><font size="5">:</font></td>
									<td><b><font size="5">Rp. </font></b></td>
									<td align="right"><b><font size="5">{{ number_format($row->amount) }}.-</font></b></td>
								@else
									@if($format->kode_perusahaan == 'WPS')
										<td width="150"><b><font size="5">WPS</b></font> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
									@elseif($format->kode_perusahaan == 'LP')
										<td width="150"><b><font size="5">LP</b></font> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
									@else
										<td width="150"><b><font size="5">{{ $row->kode_perusahaan }}</b></font> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
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
								<td width="100"></td>
								<td width="150"><b><font size="5">{{ $row->nama_depo }}</font></b></td>
							@else
								<td width="100"></td>
								@if($format->kode_perusahaan == 'WPS')
									<td width="150"><b><font size="5">WPS</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
								@elseif($format->kode_perusahaan == 'LP')
									<td width="150"><b><font size="5">LP</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
								@else
									<td width="150"><b><font size="5">{{ $row->kode_perusahaan }}</font></b> <b><font size="5">{{ $row->nama_depo }}</font></b></td>
								@endif
							
							@endif
							<td width="50" align="center"><b><font size="5">:&nbsp;&nbsp;&nbsp;Rp. </font></b></td>
							
							@if( $i == $jml_depo->jumlah )
								<td align="right"><b><u><font size="5"><font color="white">&nbsp;&nbsp;&nbsp;&nbsp;</font>{{ number_format($row->amount) }},-</font></u></b></td>
							@else
								<td align="right"><b><font size="5">{{ number_format($row->amount) }},-</font></b></td>
							@endif
							<?php $i++; ?> 
							
						</tr>
					@empty
						<tr>
						                                                
						</tr>
					@endforelse
		
						<tfoot>
						    <td width="100">&nbsp;</td>
							<td width="150"><b><font size="5">TOTAL</font></b></td>
							<td width="50" align="center"><b><font size="5">:&nbsp;&nbsp;&nbsp;Rp. </font></b></td>
							<td align="right"><b><font size="5">{{ number_format($format_total->amount) }},-</font></b></td>
						</tfoot>
					</table>
				@elseif($format_jumlah->jumlah >= '4' )
					<table>
						<tr>
						    <td width="100">&nbsp;</td>
							@if($format->kode_perusahaan == 'TUA' )
								@if($jml_perusahaan->jumlah_perusahaan == '1' )
	                               	<td width="150"><b><font size="5">TUA Bandung</font></b></td> 
	                            @else
	                                <td width="150"><b><font size="5">All Depo</font></b></td> 
	                            @endif
	                            
	                        @else
	                            <td width="150"><b><font size="5">All Depo</font></b></td>       
	                        @endif
							<td width="50" align="center"><font size="5">:</font></td>
							<td><b><font size="5">Rp. </font></b></td>
							<td align="right"><b><font size="5">{{ number_format($format_total->amount) }},-</font></b></td>
						</tr>
					</table>
				@endif		

			@else

				
                                                @if($total_sku_foot->jml == '1')
                                                <table border='1' style="border-collapse: collapse; margin-left: 120%; border-color: black;">
                                                @else
                                                <table border='1' style="border-collapse: collapse; margin-left: 90%; border-color: black;">
                                                @endif
                                                
                                               	<thead>
                                                        <tr  align="center">
                                                            
                                                            <th width="150"><font size="3">Customer Name</font></th>
                                                            @forelse($header_sku as $header)
                                                                <th align="center" width="50"><font size="3">{{ $header->nama_produk }}</font></th>
                                                            @empty

                                                            @endforelse
                                                            <!-- <th align="center" width="50"><font size="3">AQUA 600ML</font></th>
                                                            <th align="center" width="50"><font size="3">AQUA 1500ML</font></th> -->
                                                            <th width="80" align="center"><font size="3">Total Box</font></th>
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
                                                                    <?php $tot += $header->amount ?>
                                                                @endif 
																<td align="center"><font size="3">{{ number_format($tot) }}</font></td>
                                                            @empty

                                                            @endforelse
                                                            <!-- <td align="center"><font size="3"></font></td>
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
                                                <tfoot>
                                                        
                                                    </tfoot>
                                                </table>
                                            
               

			@endif

										
		</table>
		<br>
		<table>
			<tr>
				<td width="15">
				<td width="480">
					<!-- <span style="font-size: x-small;"> -->
					<p align="justify">Kami juga lampirkan {{ $format->dokumen }} lainnya.<br>
					{{ $format->penutup }}</p>
					<!-- </span> -->
				</td>
			</tr>
		</table>

		@if($format_jumlah->jumlah == '1' )
			<br>
			<br>
		@elseif($format_jumlah->jumlah < '4')
			<br>
		@elseif($format_jumlah->jumlah >= '4')
			<br>
			<br>
		@endif
		
		<table>
			@if($format->menyetujui_ext == '' && $format->menyetujui_ext2 == '')
			<tr>
				<td width="10"></td>
				<td width="120" align="center">
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

				<td ></td>

				<td width="600" align="center">
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
				<td width="150" align="center">
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

				<td width="200" align="center">
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

				<td width="170" align="center">
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
				
				<td width="110" align="center">
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

				<td width="180" align="center">
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

				<td width="230" align="center">
					<span><b>Menyetujui,</b></span><br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<table>
						<tr>
							<td width="115" align="center">
								<span><b>{{ $format->menyetujui_ext }}</b></span>
								<br>
								<span><b>{{ $format->sebagai_ext }}</b></span>
							</td>

							<td width="115" align="center">
								<span><b>{{ $format->menyetujui_ext2 }}</b></span>
								<br>
								<span><b>{{ $format->sebagai_ext2 }}</b></span>
							</td>
						</tr>
					</table>
						
					
				</td>
			</tr>							
			@endif 
		</table>
	
</body>
</html>