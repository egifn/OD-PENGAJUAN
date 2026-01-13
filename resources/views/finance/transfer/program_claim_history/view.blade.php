@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(document).ready(function() {
            //INISIASI DATERANGEPICKER
            $('#tanggal_').daterangepicker({
             
            })
        })
    </script>

    <script type="text/javascript">
        function kembali() {
            window.history.back();
        }

        $(document).on('click', '.pilih_rekening', function (e) {
            document.getElementById("nama_perusahaan").value = $(this).attr('data-nama_perusahaan');
            document.getElementById("kode_bank").value = $(this).attr('data-kode_bank');
            document.getElementById("nama_bank").value = $(this).attr('data-nama_bank');
            document.getElementById("norek").value = $(this).attr('data-norek');
            $('#myModal').modal('hide');
        });

        $(document).ready(function(){
            fetch_data_program();
            function fetch_data_program(query = '')
            {
                $.ajax({
                    url:'{{ route("pengajuan_tiv/action_rekening.actionRekening") }}',
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#lookup_list_rekening tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#cari_rekening', function(){
                var query = $(this).val();
                fetch_data_program(query);
            });
        });


        $(document).ready(function(){
            if ($("input[name='radio']:checked").val() == "transfer" ) {
                $("#form-input").hide();
                $("#button_alltransfer").hide();
                $(".aksi").show();
                $(".ceklis").hide();
            }else{
                $("#form-input").show();
                $("#button_alltransfer").show();
                $(".aksi").hide();
                $(".ceklis").show();
            }
            var disabled = false;
            $(".detail").click(function(){ 
                if ($("input[name='radio']:checked").val() == "transfer" ) { 
                    $("#form-input").slideUp("fast"); 
                    $("#button_alltransfer").hide();
                    $(".aksi").show();
                    $(".ceklis").hide();
                    
                    document.getElementById("cara_bayar").value = "";
                } else if ($("input[name='radio']:checked").val() == "bulk" ) {
                    $("#form-input").slideDown("fast"); 
                    $("#button_alltransfer").show();
                    $(".aksi").hide();
                    $(".ceklis").show();
                }
            });
        });

        $(document).ready(function() {
            $('#select-all').click(function(event) {   
                if(this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;     
                        
                        // var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
                        // for(var t = 0; t < table.length; t++)
                        // {
                        //     var i = 1+t;
                        //     if (table[t].checked) {
                        //         var row = table[t].parentNode.parentNode;
                        //         var price = row.cells[17].children[0].value;
                        //         sumHsl = sumHsl + parseInt(price);

                        //         // $('#ceklist_temp' +i+ '').text('1');
                        //     }
                        // }
                        // //membuat format rupiah//
                        // var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                        //     ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                        //     hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
                        // //End membuat format rupiah//
                        // document.getElementById('.sub_total').innerHTML =  hasil_total;
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;     
                    });
                }
            });
        });

        function chk_jumlah(x) {
            var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
            for(var t = 0; t < table.length; t++)
            {
                var row = table[t].parentNode.parentNode;
                var price = row.cells[17].children[0].value;
                

                if (table[t].checked) {
                    var row = table[t].parentNode.parentNode;
                    var price = row.cells[17].children[0].value;
                    sumHsl = sumHsl + parseInt(price);
                }
            }
            //membuat format rupiah//
            var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
            //End membuat format rupiah//
            $('#sub_total').val(hasil_total);
            $(".sub_total").text(hasil_total); 
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>History Daftar Transfer</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Transfer</li>
        <li class="breadcrumb-item active">History Daftar Transfer</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn" id="page_form">
            
                <div class="row">
                
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    History Daftar Transfer
                                </h4>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <div class="input-group">
                                            <input id="kode_perusahaan" name="kode_perusahaan" type="text" class="form-control" hidden>
                                            <input id="nama_perusahaan" name="nama_perusahaan" type="text" class="form-control" value="{{ $data_transfer_head->nama_perusahaan }}" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal" disabled> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" id="kode_depo" name="kode_depo" class="form-control" value="" hidden>
                                        <input type="text" id="nama_depo" name="nama_depo" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Bank
                                        <input type="text" id="kode_bank" name="kode_bank" class="form-control" value="" hidden>
                                        <input type="text" id="nama_bank" name="nama_bank" class="form-control" value="{{ $data_transfer_head->nama_bank }}" readonly>
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        No Rekening Perusahaan
                                        <input type="text" style="text-align: right;" id="norek" name="norek" class="form-control" value="{{ $data_transfer_head->norek }}" readonly>
                                    </div>

                                    <div class="col-md-1 mb-2">
                                        Jenis Transksi
                                        <input type="text" name="jenis" type="text" id="jenis" class="form-control" value="{{ $data_transfer_head->keterangan }}" readonly>
                                    </div>

                                    <div class="col-md-1 mb-2 ml-auto" hidden>
                                        <br>
                                        <button class="btn btn-success" name="button_excel" id="button_excel" value="excel" type="submit">E x c e l</button>
                                    </div>
    
                                    <div class="col-md-3 mb-2" hidden>
                                        No urut
                                        <input name="no_urut" type="text" id="no_urut" class="form-control" value="{{ $data_transfer_head->no_urut_pengajuan }}" />
                                    </div>
                                    
                                </div>
                            
                            
                                <div class="row" hidden>
                                    <div class="col-md-1 mb-2">
                                        <input name="radio" type="radio" id="transfer" value="transfer" class="detail" checked="true" />
                                        Transfer {{-- (tampilan detail) --}}
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <input name="radio" type="radio" id="bulk" value="bulk" class="detail" />
                                        Bulk Transfer {{-- (tampilan keseluruhan) --}}
                                    </div>
                                </div>

                                <div id="form-input" hidden>
                                    <div id="form-input" class="row">
                                        <div class="col-md-3 mb-2">
                                            Cara Pembayaran
                                            <select name="cara_bayar" id="cara_bayar" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="LLG">LLG</option>
                                                <option value="RTGA">RTGA</option>
                                                <option value="FAST">FAST - BI Fast</option>
                                                <option value="OT">OT - Online Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Value Date
                                            {{-- <input type="text" name="value_date" id="value_date" class="form-control" value="-" required> --}}
                                            <input type="date" id="tanggal" name="tanggal" class="form-control">
                                        </div> 
                                        <div class="col-md-6 mb-2">
                                            Remarks
                                            {{-- <input type="text" name="value_date" id="value_date" class="form-control" value="-" required> --}}
                                            <input type="text" id="remarks" name="remarks" class="form-control">
                                        </div> 
                                    </div>   
                                    <br>
                                </div>
                            
                                <br>
                                <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <div style="width:100%;">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>Tgl_import</th>
                                                    <th hidden>Kode_pengajuan</th>
                                                    <th>Kategori</th>
                                                    <th hidden>No Surat Program</th>
                                                    <th hidden>Id Program</th>
                                                    <th>Nama Program</th>
                                                    <th>Perusahaan</th>
                                                    <th>Depo</th>
                                                    <th hidden>Kode Toko</th>
                                                    <th>Nama Toko</th>
                                                    <th>Bank</th>
                                                    <th>No Rekening</th>
                                                    <th>Atas Nama Rekening</th>
                                                    <th>Reward Distributor</th>
                                                    <th>Reward TIV</th>
                                                    <th>Potongan</th>
                                                    <th>Total</th>
                                                    {{-- <th class="aksi">Aksi</th>
                                                    <th class="ceklis">Pilih &nbsp; <input type="checkbox" id="select-all"></th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($data_list_transfer as $row)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td class="tgl_import" hidden>
                                                        <input class="form-control" type="text" name="tgl_import[]" id="tgl_import{{ $no }}" value="{{ $row->tgl_import }}" hidden/>
                                                        {{ $row->tgl_import }}
                                                    </td>
                                                    <td class="kode_pengajuan_b" hidden>
                                                        <input class="form-control" type="text" name="kode_pengajuan_b[]" id="kode_pengajuan_b{{ $no }}" value="{{ $row->kode_pengajuan_b }}" hidden/>
                                                        {{ $row->kode_pengajuan_b }}
                                                    </td>
                                                    <td class="kategori">
                                                        <input class="form-control" type="text" name="kategori[]" id="kategori{{ $no }}" value="{{ $row->kategori }}" hidden/>
                                                        {{ $row->kategori }}
                                                    </td>
                                                    <td class="no_surat_program" hidden>
                                                        <input class="form-control" type="text" name="no_surat_program[]" id="no_surat_program{{ $no }}" value="{{ $row->no_surat_program }}" hidden/>
                                                        {{ $row->no_surat_program }}
                                                    </td>
                                                    <td class="id_program_ssd" hidden>
                                                        <input class="form-control" type="text" name="id_program_ssd[]" id="id_program_ssd{{ $no }}" value="{{ $row->id_program_ssd }}" hidden/>
                                                        {{ $row->id_program_ssd }}
                                                    </td>
                                                    <td class="nama_program">
                                                        <input class="form-control" type="text" name="nama_program[]" id="nama_program{{ $no }}" value="{{ $row->nama_program }}" hidden/>
                                                        {{ $row->nama_program }}
                                                    </td>
                                                    <td class="kode_perusahaan_detail">
                                                        <input class="form-control" type="text" name="kode_perusahaan_detail[]" id="kode_perusahaan_detail{{ $no }}" value="{{ $row->kode_perusahaan_detail }}" hidden/>
                                                        {{ $row->kode_perusahaan_detail }}
                                                    </td>
                                                    <td class="nama_depo">
                                                        <input class="form-control" type="text" name="nama_depo[]" id="nama_depo{{ $no }}" value="{{ $row->nama_depo }}" hidden/>
                                                        {{ $row->nama_depo }}
                                                    </td>
                                                    <td class="kode_outlet" hidden>
                                                        <input class="form-control" type="text" name="kode_outlet[]" id="kode_outlet{{ $no }}" value="{{ $row->kode_outlet }}" hidden/>
                                                        {{ $row->kode_outlet }}
                                                    </td>
                                                    <td class="nama_outlet">
                                                        <input class="form-control" type="text" name="nama_outlet[]" id="nama_outlet{{ $no }}" value="{{ $row->nama_outlet }}" hidden/>
                                                        {{ $row->nama_outlet }}
                                                    </td>
                                                    <td class="bank_rekening">
                                                        <input class="form-control" type="text" name="bank_rekening[]" id="bank_rekening{{ $no }}" value="{{ $row->bank_rekening }}" hidden/>
                                                        {{ $row->bank_rekening }}
                                                    </td>
                                                    <td class="no_rekening">
                                                        <input class="form-control" type="text" name="no_rekening[]" id="no_rekening{{ $no }}" value="{{ $row->no_rekening }}" hidden/>
                                                        {{ $row->no_rekening }}
                                                    </td>
                                                    <td class="nama_rekening">
                                                        <input class="form-control" type="text" name="nama_rekening[]" id="nama_rekening{{ $no }}" value="{{ $row->nama_rekening }}" hidden/>
                                                        {{ $row->nama_rekening }}
                                                    </td>
                                                    <td class="reward" align="right">
                                                        <input class="form-control" type="text" name="reward[]" id="reward{{ $no }}" value="{{ $row->reward }}" hidden/>
                                                        {{ number_format($row->reward) }}
                                                    </td>
                                                    <td class="reward_tiv" align="right">
                                                        <input class="form-control" type="text" name="reward_tiv[]" id="reward_tiv{{ $no }}" value="{{ $row->reward_tiv }}" hidden/>
                                                        {{ number_format($row->reward_tiv) }}
                                                    </td>
                                                    <td class="potongan" align="right">
                                                        <input class="form-control" type="text" name="potongan[]" id="potongan{{ $no }}" value="{{ $row->potongan }}" hidden/>
                                                        {{ number_format($row->potongan) }}
                                                    </td>
                                                    <td class="total" align="right">
                                                        <input class="form-control" type="text" name="total[]" id="total{{ $no }}" value="{{ $row->total }}" hidden/>
                                                        {{ number_format($row->total) }}
                                                    </td>
                                                        
                                                    {{-- <td class="aksi">
                                                        <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_transfer( {{ $no }} );">Transfer</button>
                                                    </td>

                                                    <td class="ceklis" align="center">
                                                        <input type="checkbox" name="chk[]" id="chk{{ $no }}" class="checkbox" onclick="chk_jumlah( {{ $no }} );" data-index=" {{ $no }} " value="{{ $row->kode_outlet }}"/>
                                                    </td> --}}
                                                </tr>
                                                <?php $no++; ?>
                                                @empty
                                                <tr>
                                                        
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9s" align="center"><b>Total:</b></td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="ttl_reward_dis" id="ttl_reward_dis" style="font-size: 13px;" value="{{ $data_list_transfer->sum('reward') }}" hidden>
                                                        <b>{{ $data_list_transfer->sum('reward') }}</b> &nbsp;
                                                    </td>
                        
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="ttl_reward_tiv" id="ttl_reward_tiv" style="font-size: 13px;" value="{{ $data_list_transfer->sum('reward_tiv') }}" hidden>
                                                        <b>{{ number_format($data_list_transfer->sum('reward_tiv')) }}</b> &nbsp;
                                                    </td>

                                                    <td align="right">
                                                        <input type="text" class="form-control" name="ttl_potongan" id="ttl_potongan" style="font-size: 13px;" value="{{ $data_list_transfer->sum('potongan') }}" hidden>
                                                        <b>{{ number_format($data_list_transfer->sum('potongan')) }}</b> &nbsp;
                                                    </td>

                                                    <td align="right">
                                                        <input type="text" class="form-control" name="sub_total" id="sub_total" style="font-size: 13px;" value="{{ $data_list_transfer->sum('total') }}" hidden>
                                                        <b>{{ number_format($data_list_transfer->sum('total')) }}</b> &nbsp;
                                                    </td>
                                                         
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                    
                                <div class="col-mb-15 float-right">
                                    {{-- <button type="button" name="button_alltransfer" id="button_alltransfer" class="btn btn-success btn-sm" onclick="all_transfer();">T r a n s f e r</button> --}}
                                    <button class="btn btn-primary btn-sm" name=kembali id="kembali" onclick="kembali()">K e m b a l i</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
            
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="input-group mb-3 col-md-4 float-right">
                    <input type="text" name="cari_rekening" id="cari_rekening" class="form-control" placeholder="Search Data . . .">
                </div>
              
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_list_rekening" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                
                                <th>Perusahaan</th>
                                <th hidden>kode_bank</th>
                                <th>Bank</th>
                                <th>No Rekening</th>
                            </tr>
                        </thead>
                        <tbody>
                      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
