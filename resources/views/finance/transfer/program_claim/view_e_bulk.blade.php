@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename = $remarks.xls");
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


<H2>Upload OCBC Bulk Transfer</H2>

<div>
    <br>
    <table>
        <thead>
            <tr style="background-color: skyblue">
				<th>Nama Outlet</th>
                <th>No</th>
                <th>ProductType (4)</th>
                <th>CustomerRef (20)</th>
                <th>ValueDate (8)</th>
                <th>DebitAcctCcy (3)</th>
                <th>DebitAcctNo (19)</th>
                <th>CreditAcctCcy (3)</th>
                <th>CreditAcctNo (19)</th>
                <th>TransferCcy (3)</th>
                <th>TransferAmount (18)</th>
                <th>Remarks (100)</th>
                <th>FxType (1)</th>
                <th>FxDealerName (35)</th>
                <th>FxDealRef1 (30)</th>
                <th>FxDealAmt1 (14)</th>
                <th>ReservedColumn</th>
                <th>ReservedColumn</th>
                <th>SwiftChargesMethod (3)</th>
                <th>SenderName (35)</th>
                <th>SenderAddr1 (100)</th>
                <th>SenderAddr2 (100)</th>
                <th>SenderAddr3 (100)</th>
                <th>PayeeName (100)</th>
                <th>PayeeAddr1 (100)</th>
                <th>PayeeAddr2 (100)</th>
                <th>PayeeAddr3 (100)</th>
                <th>BeneBankID (3)</th>
                <th>BeneBankNetworkID (20)</th>
                <th>BeneBankName (100)</th>
                <th>BeneBankBranchName (50)</th>
                <th>BeneBankCountryCode (2)</th>
                <th>ResidentStatus (1)</th>
                <th>RemittanceCountryOfResidence (2)</th>
                <th>RemitterCategory (4)</th>
                <th>BeneCountryOfResidence (2)</th>
                <th>BeneCategory (4)</th>
                <th>BeneAffiliationStatus (1)</th>
                <th>PaymentPurpose (5)</th>
                <th>DoubleCheck_CustRefNo (1)</th>
                <th>DoubleCheck_TrfAmtCcy (1)</th>
                <th>Add_FavPayment (1)</th>
                <th>Add_Template (1)</th>
                <th>Notf_Sender (1)</th>
                <th>Notf_Sender_Completed (1)</th>
                <th>Notf_Sender_Rejected (1)</th>
                <th>Notf_Sender_Suspected (1)</th>
                <th>Notf_Sender_ChannelType (5)</th>
                <th>Notf_Sender_DestID (100)</th>
                <th>Notf_Bene_Completed (1)</th>
                <th>Notf_Bene_ChannelType (5)</th>
                <th>Notf_Bene_DestID (100)</th>
                <th>Recr_On (1)</th>
                <th>Recr_On_Type (2)</th>
                <th>Recr_On_Type_Value (2)</th>
                <th>Recr_Date_Start (8)</th>
                <th>Recr_Date_End (8)</th>
                <th>SaveAsBeneficiary (1)</th>
                <th>BeneNickName (40)</th>
                <th>BeneEmailAddress (100)</th>
                <th>BenePhoneNumber (20)</th>
                <th>UnderlyingType (10)</th>
                <th>UnderlyingDoc (10)</th>  
                <th>Beneficiary Type (8)</th>
                <th>Mobile No - If Beneficiary Type FAST02 (50)</th>
                <th>Email Address - If Beneficiary Type FAST03 (50)</th>
                <th>ChargesAcctCcy (3)</th>
                <th>ChargesAcctNo (19)</th>
                <th>PurposeofTransaction (2)</th> 
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse ($data_list_transfer as $row)
            <tr>
				<td>
                    {{ $row->nama_outlet }}<br>
                </td>
                <td>{{ $no }}</td>
                <td>
                    {{ $cara_bayar }}<br>
                </td>                              
                <td>                                 
                    
                </td>
                <td>           
                    {{ date('Ymd', strtotime($tanggal)) }}          
                </td>
                <td>                    
                    IDR
                </td>                       
                <td>                              
                    '{{ str_replace(' ', '', $norek) }}
                </td>
                <td>                         
                    IDR
                </td>
                <td>                        
                    '{{ str_replace(' ', '', $row->no_rekening) }}
                </td>
                <td>                        
                    IDR
                </td>
                <td>                      
                    {{ $row->total - $row->piutang_ng - $row->piutang_depo }}
                </td>
                <td>                   
                    {{ $remarks }}
                </td>
                <td>             
                    
                </td>
                <td>                    
                    
                </td>    
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    {{ $atas_nama_perusahaan }}
                </td>
                <td>                     
                    {{ $row->nama_depo }}
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
				@if($cara_bayar=='LLG' || $cara_bayar=='RTGS')
                    <td>                     
                        {{ $row->nama_rekening }}  
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif
                @if($cara_bayar=='LLG' || $cara_bayar=='RTGS')
                    <td>                     
						{{ $row->nama_depo }}  
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                @if($cara_bayar=='LLG' || $cara_bayar=='RTGS' || $cara_bayar=='OT')
                    <td>                     
                        '{{ $row->bene_bank_id }}  
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif

                @if($cara_bayar=='LLG')
                    <td>                     
                        {{ $row->llg_clearing_id }}  
                    </td>
                @elseif($cara_bayar=='RTGS')
                    <td>                     
                        {{ $row->member_code }}
                    </td>
                @elseif($cara_bayar=='FAST')
                    <td>                     
                        {{ $row->member_code }}
                    </td>
                @else
                    <td>                     
                            
                    </td>
                @endif
                <td>                     
                    {{ $row->bene_bank_name }}
                </td>
                @if($cara_bayar=='LLG' || $cara_bayar=='RTGS' || $cara_bayar=='OT')
                    <td>                     
                        {{ $row->bene_bank_branch_name }}  
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif
                <td>                     
                    
                </td>
                @if($cara_bayar=='LLG' || $cara_bayar=='RTGA')
                    <td>                     
                        Y  
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif
                <td>                     
                    
                </td>
                @if($cara_bayar=='LLG')
                    <td>                     
                        E0
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif
                <td>                     
                    
                </td>
                @if($cara_bayar=='LLG')
                    <td>                     
                        A0 
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    1
                </td>
                <td>                     
                    '0
                </td>
                <td>                     
                    1
                </td>
                <td>                     
                    1
                </td>
                <td>                     
                    EMAIL
                </td>
                <td>                     
                    ragidkaa@gmail.com
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    {{-- email --}}
                </td>
                <td>                     
                    {{-- alamat email --}}
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                
                <td>                     
                    
                </td>
                @if($cara_bayar=='FAST')
                    <td>                     
                        FAST01  
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                <td>                     
                    
                </td>
                @if($cara_bayar=='FAST')
                    <td>                     
                        '99
                    </td>
                @else
                    <td>                     
                        
                    </td>
                @endif

            </tr>
            <?php $no++; ?>


                @if($row->piutang_ng != '0')
                    @if($row->status_upload_ng == 0)
                        <td>
                            Piutang NG
                        </td>
                        <td></td>
                        <td>
                            {{ $cara_bayar }}<br>
                        </td>                              
                        <td>                                 
                            
                        </td>
                        <td>           
                            {{ date('Ymd', strtotime($tanggal)) }}          
                        </td>
                        <td>                    
                            IDR
                        </td>                       
                        <td>                              
                            '{{ str_replace(' ', '', $norek) }}
                        </td>
                        <td>                         
                            IDR
                        </td>
                        <td>                        
                            '{{ str_replace(' ', '', $row->norek_ng) }}
                        </td>
                        <td>                        
                            IDR
                        </td>
                        <td>                      
                            {{ $row->piutang_ng }}
                        </td>
                        <td>                   
                            {{ $remarks }}
                        </td>
                        <td>             
                            
                        </td>
                        <td>                    
                            
                        </td>    
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            {{ $atas_nama_perusahaan }}
                        </td>
                        <td>                     
                            {{ $row->nama_depo }}
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS')
                            <td>                     
                                {{ $row->atas_nama_rek_ng }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS')
                            <td>                     
                                {{ $row->nama_depo }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS' || $cara_bayar=='OT')
                            <td>                     
                                '{{ $row->bene_bank_id }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
        
                        @if($cara_bayar=='LLG')
                            <td>                     
                                {{ $row->llg_clearing_id }}  
                            </td>
                        @elseif($cara_bayar=='RTGS')
                            <td>                     
                                {{ $row->member_code }}
                            </td>
                        @elseif($cara_bayar=='FAST')
                            <td>                     
                                {{ $row->member_code }}
                            </td>
                        @else
                            <td>                     
                                    
                            </td>
                        @endif
                        <td>                     
                            {{ $row->bene_bank_name }}
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS' || $cara_bayar=='OT')
                            <td>                     
                                {{ $row->bene_bank_branch_name }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGA')
                            <td>                     
                                Y  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG')
                            <td>                     
                                E0
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG')
                            <td>                     
                                A0 
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            1
                        </td>
                        <td>                     
                            '0
                        </td>
                        <td>                     
                            1
                        </td>
                        <td>                     
                            1
                        </td>
                        <td>                     
                            EMAIL
                        </td>
                        <td>                     
                            ragidkaa@gmail.com
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            {{-- email --}}
                        </td>
                        <td>                     
                            {{-- alamat email --}}
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='FAST')
                            <td>                     
                                FAST01  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='FAST')
                            <td>                     
                                '99
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                    @endif
                @endif

                @if($row->piutang_depo != '0')
                    @if($row->status_upload_depo == 0)
                        <td>
                            Piutang Depo
                        </td>
                        <td></td>
                        <td>
                            {{ $cara_bayar }}<br>
                        </td>                              
                        <td>                                 
                            
                        </td>
                        <td>           
                            {{ date('Ymd', strtotime($tanggal)) }}          
                        </td>
                        <td>                    
                            IDR
                        </td>                       
                        <td>                              
                            '{{ str_replace(' ', '', $norek) }}
                        </td>
                        <td>                         
                            IDR
                        </td>
                        <td>                        
                            '{{ str_replace(' ', '', $row->norek_depo) }}
                        </td>
                        <td>                        
                            IDR
                        </td>
                        <td>                      
                            {{ $row->piutang_depo }}
                        </td>
                        <td>                   
                            {{ $remarks }}
                        </td>
                        <td>             
                            
                        </td>
                        <td>                    
                            
                        </td>    
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            {{ $atas_nama_perusahaan }}
                        </td>
                        <td>                     
                            {{ $row->nama_depo }}
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS')
                            <td>                     
                                {{ $row->atas_nama_rek_depo }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS')
                            <td>                     
                                {{ $row->nama_depo }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS' || $cara_bayar=='OT')
                            <td>                     
                                '{{ $row->bene_bank_id }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
        
                        @if($cara_bayar=='LLG')
                            <td>                     
                                {{ $row->llg_clearing_id }}  
                            </td>
                        @elseif($cara_bayar=='RTGS')
                            <td>                     
                                {{ $row->member_code }}
                            </td>
                        @elseif($cara_bayar=='FAST')
                            <td>                     
                                {{ $row->member_code }}
                            </td>
                        @else
                            <td>                     
                                    
                            </td>
                        @endif
                        <td>                     
                            {{ $row->bene_bank_name }}
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGS' || $cara_bayar=='OT')
                            <td>                     
                                {{ $row->bene_bank_branch_name }}  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG' || $cara_bayar=='RTGA')
                            <td>                     
                                Y  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG')
                            <td>                     
                                E0
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='LLG')
                            <td>                     
                                A0 
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            1
                        </td>
                        <td>                     
                            '0
                        </td>
                        <td>                     
                            1
                        </td>
                        <td>                     
                            1
                        </td>
                        <td>                     
                            EMAIL
                        </td>
                        <td>                     
                            ragidkaa@gmail.com
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            {{-- email --}}
                        </td>
                        <td>                     
                            {{-- alamat email --}}
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='FAST')
                            <td>                     
                                FAST01  
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        <td>                     
                            
                        </td>
                        @if($cara_bayar=='FAST')
                            <td>                     
                                '99
                            </td>
                        @else
                            <td>                     
                                
                            </td>
                        @endif
                    @endif
                @endif


            @empty
                <tr>
                                                        
                </tr>
            @endforelse
        </tbody>
    </table>
</div>                  







