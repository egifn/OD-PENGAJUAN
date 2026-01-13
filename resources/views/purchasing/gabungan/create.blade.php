        <div class="animated fadeIn">
            <form action="{{ route('po_gabungan/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Purchase Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">kode_rekap/pengajuan</label>
                                        <input type="text" name="kode" class="form-control" value="{{ $datas_po_header->kode_rekap }}" required readonly>    
                                    </div>

                                    <div class="col-md-4 mb-2" hidden>
                                        <label for="kode">No PO</label>
                                        <input type="text" name="kode_pembelian" class="form-control" value="{{ $kode }}" required readonly>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Tanggal PO</label>
                                        <input type="text" name="tgl_pembelian" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="nama">Yang Membuat</label>
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Untuk Perusahaan</label>
                                        <select name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" required>
                                            <option value="">Pilih Perusahaan</option>
                                            @foreach ($perusahaans as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="supplier">Vendor</label>
                                        <div class="input-group">
                                            <input id="supplier" type="text" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ old('kode_supp') }}" required readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalsupp"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                        <p class="text-danger">{{ $errors->first('kode_supp') }}</p>
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
                                        <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th hidden>Kode Rekap</th>
                                                        <th>Product Id</th>
                                                        <th>Product Name</th>
                                                        <th>Merk</th>
                                                        <th>Desc/Spek</th>
                                                        <th>Qty</th>
                                                        <th>Qty Pesan</th>
                                                        <th>Satuan</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1; ?>
                                                    @forelse($datas_po as $val)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td hidden>
                                                            <input type="text" class="form-control" name="kode_rekap[]" id="kode_rekap_" style="font-size: 13px;" value="{{ $val->kode_rekap }}" readonly hidden>
                                                            {{ $val->kode_rekap }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_" style="font-size: 13px;" value="{{ $val->kode_product }}" readonly hidden>
                                                            {{ $val->kode_product }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="nama_produk[]" id="nama_produk_" style="font-size: 13px;" value="{{ $val->nama_barang }}" readonly hidden>
                                                            {{ $val->nama_barang }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="merk[]" id="merk_" style="font-size: 13px;" value="{{ $val->merk }}" readonly hidden>
                                                            {{ $val->merk }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="ket[]" id="ket_" style="font-size: 13px;" value="{{ $val->ket }}" readonly hidden>
                                                            {{ $val->ket }}
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="qty[]" id="qty_{{ $i }}" style="font-size: 13px; text-align: right;" value="{{ $val->total_sisa_qty_po }}" readonly hidden>
                                                            {{ $val->total_sisa_qty_po }}
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="qty_po[]" id="qty_po_{{ $i }}" style="font-size: 13px; text-align: right;" onclick="jumlah( {{$i}} )" onkeyup="jumlah( {{$i}} )" value="0">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="satuan[]" id="satuan_" style="font-size: 13px; text-align: right;" value="{{ $val->satuan }}" readonly hidden>
                                                            {{ $val->satuan }}
                                                        </td>
                                                        <td align="right">
                                                            <input type="text" class="form-control" name="harga[]" id="harga_{{ $i }}" style="font-size: 13px; text-align: right;" onclick="jumlah( {{$i}} )" onkeyup="jumlah( {{$i}} )" value="{{ number_format($val->price) }}">
                                                        </td>
                                                        <td align="right">
                                                            <input type="text" class="form-control" name="total[]" id="total_{{ $i }}" style="font-size: 13px; text-align: right;" value="0" readonly>
                                                        </td>
                                                        
                                                    </tr>
                                                    <?php $i++; ?>
                                                    @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Tabel temp --}}

                                        <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;" hidden>
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput_a">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Pengajuan</th>
                                                        <th>tgl_pengajuan</th>
                                                        <th>Product Id</th>
                                                        <th>Product Name</th>
                                                        <th>Merk</th>
                                                        <th>Desc/Spek</th>
                                                        <th>Qty</th>
                                                        <th>Satuan</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>    
                                    <div class="row"> 
                                        <div class="col-md-10 mb-2">
                                            <label for="supplier" class="float-right" style="font-size:25px;">Total</label>
                                        </div>  
                                        <div class="col-md-2 mb-2">
                                            <input type="text" name="total_harga" id="total_harga" class="form-control" value="" style="text-align:right; font-style:bold;" required readonly>
                                        </div>
                                    </div>
                                
                                    <div class="row">
                                        
                                        
                                        <div class="col-md-10 mb-2">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Buat dan Simpan PO</button>
                                        </div> 
                                        <div class="col-md-2 mb-3 float-right">
                                            <a href="{{ route('po_gabungan.index') }}" class="btn btn-primary btn-sm">K e m b a l i</a>
                                            
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </form>
        </div>
        
<div class="modal fade bd-example-modal-lg" id="myModalsupp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_vendor" id="search_vendor" class="form-control" placeholder="Cari Vendor...">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_vendor" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Vendor</th>
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

@section('js')
<script type="text/javascript">
    var tot =0;

    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById('kode_supp').value = $(this).attr('data-kode_vendor')
        document.getElementById('supplier').value = $(this).attr('data-nama_vendor')

        $('#myModalsupp').modal('hide');
    });

    function jumlah(x){
        var txtharga_temp = $('#harga_'+x+'').val();
        // //menghilangka format rupiah harga//
        var sub_total_non_format = txtharga_temp.replace(/[.](?=.*?\.)/g, '');
        var txtharga = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
        // //End menghilangka format rupiah harga//

        var txtqty_awal = $('#qty_'+x+'').val(); 
        var txtqty = $('#qty_po_'+x+'').val();

        if(parseInt(txtqty) > parseInt(txtqty_awal)){
            alert('Jml qty Pesanan melebihi dari jumlah Qty awal....');
            $('#qty_po_'+x+'').val(txtqty_awal);
        }else{
            txttotal =txtharga * txtqty;    
            var format_txttotal = txttotal.toString().split('').reverse().join(''),
                    ribuan  = format_txttotal.match(/\d{1,3}/g);
                    hasil_format_txttotal = ribuan.join(',').split('').reverse().join('');
            $('#total_'+x+'').val(hasil_format_txttotal);
            
            var table = document.getElementById("tabelinput"), sumHsl = 0;
            for(var t = 1; t < table.rows.length; t++)
            {
                var row = table.rows[t];
                var cells = row.cells;
                var inputElement = cells[10].querySelector('input[type="text"]');

                if (inputElement) {
                    var sub_total = inputElement.value;
                }
                // //menghilangka format rupiah harga//
                var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                // //End menghilangka format rupiah harga//

                sumHsl = sumHsl + parseInt(sub_total_hasil);
                //membuat format rupiah total//
                var format_sumHsl = sumHsl.toString().split('').reverse().join(''),
                    ribuan  = format_sumHsl.match(/\d{1,3}/g);
                    hasil_format_sumHsl = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                document.getElementById("total_harga").value = (hasil_format_sumHsl);
            }
        }
        // tot += parseInt(txttotal);
        // tot1 = tot;
        // document.getElementById("total_harga").value = (tot1); 
    }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("po_gabungan/store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });


    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("po_gabungan/action_vendor.actionVendor") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_vendor tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_vendor', function(){
            var query = $(this).val();
            fetch_vendor_data(query);
        });
    });


    $(document).ready(function(){
        // var table = document.getElementById("tabelinput"), sumHsl = 0;
        // for(var t = 1; t < table.rows.length; t++)
        // {
        //     var sub_total = table.rows[t].cells[10].innerHTML;
        //     alert(sub_total);
        //     // //menghilangka format rupiah harga//
        //     var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
        //     var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
        //     // //End menghilangka format rupiah harga//

        //     sumHsl = sumHsl + parseInt(sub_total_hasil);
        //     //membuat format rupiah total//
        //     var format_sumHsl = sumHsl.toString().split('').reverse().join(''),
        //         ribuan  = format_sumHsl.match(/\d{1,3}/g);
        //         hasil_format_sumHsl = ribuan.join(',').split('').reverse().join('');
        //     //End membuat format rupiah total//

        //     $('#total_harga').val(hasil_format_sumHsl);
        // }

    });

</script>


