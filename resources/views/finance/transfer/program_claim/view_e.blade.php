@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Rekap_Upload.xls");
@endphp

<style>
table, td, th {
  border: 1px outset gray;
}

table {
  width: 100%;
  border-collapse: collapse;
}
</style>


<H2>Upload Transfer</H2>

<div>
    {{-- <b>Periode: {{ request()->tanggal_ex }} </b> --}}
    <br>
    <table>
        <thead>
            <tr style="background-color: skyblue">
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Program</th>
                <th>Perusahaan</th>
                <th>Depo</th>
                <th>Nama Toko</th>
                <th>Bank</th>
                <th>No Rekening</th>
                <th>Atas Nama Rekening</th>
                <th>Reward Distributor</th>
                <th>Reward TIV</th>
                <th>Potongan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse ($data_list_transfer as $row)
            <tr>
                <td>{{ $no }}</td>
                <td class="kategori">
                    {{ $row->kategori }}
                </td>                              
                <td class="nama_program">                                 
                    {{ $row->nama_program }}
                </td>
                <td class="kode_perusahaan_detail">                     
                    {{ $row->kode_perusahaan_detail }}
                </td>
                <td class="nama_depo">                    
                    {{ $row->nama_depo }}
                </td>                       
                <td class="nama_outlet">                              
                    {{ $row->nama_outlet }}
                </td>
                <td class="bank_rekening">                         
                    {{ $row->bank_rekening }}
                </td>
                <td class="no_rekening">                        
                    '{{ $row->no_rekening }}
                </td>
                <td class="nama_rekening">                        
                    {{ $row->nama_rekening }}
                </td>
                <td class="reward" align="right">                      
                    {{ $row->reward }}
                </td>
                <td class="reward_tiv" align="right">                   
                    {{ $row->reward_tiv }}
                </td>
                <td class="potongan" align="right">             
                    {{ $row->potongan }}
                </td>
                <td class="total" align="right">                    
                    {{ $row->total - $row->piutang_ng - $row->piutang_depo }}
                </td>                                
            </tr>
            <?php $no++; ?>
            <!-- untuk Piutadepo depo dan piutang depo -->
                @if($row->piutang_ng != '0')
                    @if($row->status_upload_ng == 0)
                        <td></td>
                        <td class="kategori_ng">
                            {{ $row->kategori }}
                        </td>                              
                        <td class="nama_program_ng">                                 
                            {{ $row->nama_program }}
                        </td>
                        <td class="kode_perusahaan_detail_ng">                     
                            {{ $row->kode_perusahaan_detail }}
                        </td>
                        <td class="nama_depo_ng">                     
                            Piutang NG
                        </td>
                        <td class="nama_ng">                     
                            {{ $row->nama_outlet }}
                        </td>
                        <td class="bank_ng">                     
                            {{ $row->nama_bank_ng }}
                        </td>
                        <td class="norek_ng">                     
                            '{{ $row->norek_ng }}
                        </td>
                        <td class="atas_nama_ng">                     
                            {{ $row->atas_nama_rek_ng }}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="piutang_ng">
                            {{ $row->piutang_ng }}
                        </td>
                    @endif
                @endif

                @if($row->piutang_depo != '0')
                    @if($row->status_upload_depo == 0)
                        <td></td>
                        <td class="kategori_depo">
                            {{ $row->kategori }}
                        </td>                              
                        <td class="nama_program_depo">                                 
                            {{ $row->nama_program }}
                        </td>
                        <td class="kode_perusahaan_detail_depo">                     
                            {{ $row->kode_perusahaan_detail }}
                        </td>
                        <td class="nama_depo_depo">                     
                            Piutang Depo
                        </td>
                        <td class="nama_depo">                     
                            {{ $row->nama_outlet }}
                        </td>
                        <td class="bank_depo">                     
                            {{ $row->nama_bank_depo }}
                        </td>
                        <td class="norek_depo">                     
                            '{{ $row->norek_depo }}
                        </td>
                        <td class="atas_nama_depo">                     
                            {{ $row->atas_nama_rek_depo }}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="piutang_depo">
                            {{ $row->piutang_depo }}
                        </td>
                    @endif
                @endif
            @empty
                <tr>
                                                        
                </tr>
            @endforelse
        </tbody>
    </table>
</div>                  







