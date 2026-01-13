@section('js')
<script type="text/javascript">
   
function formatRupiah(angka) {
    if (isNaN(angka)) angka = 0;
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function jumlah(no) {
    // Ambil qty & price baris ini
    var qty = parseFloat($('#qty' + no).val().replace(/[^0-9]/g, '')) || 0;
    var harga = $('#price' + no).val().replace(/\./g, '');
    harga = parseFloat(harga.replace(/[^0-9]/g, '')) || 0;

    // Hitung total baris
    var totalBaris = qty * harga;
    $('#total_price' + no).val(formatRupiah(totalBaris));

    // Hitung ulang semua total harga
    var grandTotal = 0;
    $('input[name="total_price[]"]').each(function() {
        var val = $(this).val().replace(/\./g, '');
        grandTotal += parseFloat(val.replace(/[^0-9]/g, '')) || 0;
    });

    // Tampilkan ke input total bawah
    $('#total').val(formatRupiah(grandTotal));
}


$('#savedatas').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        url: '{{ route("pengajuan_biaya/edit.edit") }}',
        type: 'POST',
        data: $(this).serializeArray(),
        success: function(data){
            console.log(data);
        }
    });
});

$(function(){
    $('#kode_perusahaan').change(function(){
        var perusahaan_id = $(this).val();
        if(perusahaan_id){
            $.ajax({
                type:"GET",
                url:"/ajax?perusahaan_id="+perusahaan_id,
                dataType:'JSON',
                success: function(res){
                    if(res){
                        $("#kode_depo").empty();
                        $("#kode_depo").append('<option>Select</option>');
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

$(document).ready(function() {
            // Simpan file yang sudah dipilih dalam variabel
            var selectedFiles = [];

            // Fungsi untuk memperbarui file yang sudah dipilih
            function updateFileList() {
                var fileInput = $("#file_input")[0];
                fileInput.files = new DataTransfer().files; // Kosongkan input file

                var dataTransfer = new DataTransfer();
                for (var i = 0; i < selectedFiles.length; i++) {
                    dataTransfer.items.add(selectedFiles[i]);
                }
                fileInput.files = dataTransfer.files;

                // Tampilkan daftar file yang sudah dipilih
                var fileList = $("#fileList");
                fileList.empty();
                var fileNames = [];
                for (var i = 0; i < selectedFiles.length; i++) {
                    fileNames.push(selectedFiles[i].name);
                    var fileItem = $("<div>").text(selectedFiles[i].name).css({
                        "display": "flex",
                        "align-items": "center",
                        "border": "1px",
                    });
                    var removeButton = $("<button>").text("x").css({
                        "margin-left": "7px",
                        "margin-right": "7px",
                        "color": "white",
                        "background-color": "gray",
                        "border": "none",
                        "border-radius": "50%",
                        "width": "20px",
                        "height": "20px",
                        "display": "flex",
                        "justify-content": "center",
                        "align-items": "center"
                    }).attr("data-index", i).click(function() {
                        var index = $(this).attr("data-index");
                        selectedFiles.splice(index, 1);
                        updateFileList();
                    });
                    fileItem.append(removeButton);
                    fileList.append(fileItem);
                }

                // Perbarui input teks dengan nama-nama file yang dipilih
                $("#file_input").val(fileNames.join(", "));
            }

            // Saat input file berubah, tambahkan file baru ke daftar yang sudah ada
            $("#file_input").on("change", function(e) {
                var files = e.target.files;
                for (var i = 0; i < files.length; i++) {
                    selectedFiles.push(files[i]);
                }
                updateFileList();
            });

            // Fungsi validasi untuk pengecekan input file
            function validateForm() {
                var id_pengeluaran = $("#id_pengeluaran").val();
                if (id_pengeluaran == 31 || id_pengeluaran == 19) {
                    if (selectedFiles.length === 0) {
                        pesanText_3.text(
                            'Untuk pengajuan di luar ATK harus disertakan dengan Lampiran/Attachment pendukung. Lampiran/Attachment wajib diisi...'
                        );
                        modal_3.modal('show');
                        $("#file_input").focus();
                        return false;
                    }
                }
                return true;
            }

            // Gantikan return false dalam validasi form dengan pemanggilan fungsi validateForm()
            $("#submit_form").on("submit", function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });
        });


</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Edit Pengajuan</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Pengajuan Biaya/Jasa</li>
        <li class="breadcrumb-item active">Edit Pengajuan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan_biaya/edit.edit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Edit Pengajuan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" class="form-control" value="{{Auth::user()->kode_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="kode_depo" class="form-control" value="{{Auth::user()->kode_depo}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Divisi
                                        <input type="text" name="kode_divisi" class="form-control" value="{{Auth::user()->kode_divisi}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" id="ket" class="form-control" value="{{ $data_pengajuan->keterangan }}" required>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-2 mb-2" hidden>
                                        Type
                                        <select name="tipe" class="form-control">
                                            <option value="">Select</option>
                                            <option value="OPS Rit">OPS Rit</option>
                                            <option value="BBM">BBM</option>
                                            <option value="Bengkel">Bengkel</option>
                                            <option value="Materai">Materai</option>
                                            <option value="REX">REX</option>
                                            <option value="Telepon/Internet">Telepon/Internet</option>
                                            <option value="Tiki">Tiki</option>
                                            <option value="Weekly">Weekly</option>
                                        </select>
                                       
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Nama Pengeluaran
                                       
                                        <div class="input-group">
                                            <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" value="{{ $data_pengajuan->kategori }}" required >
                                            <input id="nama_pengeluaran" type="text" class="form-control" value="{{ $data_pengajuan->nama_pengeluaran }}" readonly required>
                                            <input id="sifat" type="hidden" name="sifat" class="form-control" value="{{ $data_pengajuan->sifat }}" required>
                                            <input id="jenis" type="hidden" name="jenis" class="form-control" value="{{ $data_pengajuan->jenis }}" required>
                                            <input id="pembayaran" type="hidden" name="pembayaran" class="form-control" value="{{ $data_pengajuan->pembayaran }}" required>
                                            <input id="kategori" type="hidden" name="kategori" class="form-control"  required>
                                            <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran" value="{{ $data_pengajuan->coa }}" class="form-control"  required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori" disabled> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                       
                                    </div>

                                    {{-- <div class="col-md-6 mb-2">
                                        C O A
                                        <div class="input-group">
                                            <input id="coa" type="text" class="form-control" value="{{ $data_pengajuan->nama_transaksi }}" readonly >
                                            <input id="kode_coa" type="hidden" name="kode_coa" value="{{ $data_pengajuan->no_coa_transaksi }}"  readonly>
                                            <input id="debit" type="hidden" name="debit" value="" readonly>
                                            <input id="kredit" type="hidden" name="kredit" value="" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalCoa" disabled> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" class="form-control" value="{{ $data_pengajuan->no_urut }}" required>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan_b" class="form-control" value="{{ $data_pengajuan->kode_pengajuan_b }}" required>
                                    </div>

                                    
                                </div>
                            </div>

                        </div>
                    </div>
                    
                        <div class="col-md-12">
                            <div class="card">
                                
                                <form id="savedatas">
                                <div class="card-body">
                                    <?php $no=1; ?>
                                    @forelse ($data_detail as $row)
                                        <div class="field_wrapper">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3" hidden>
                                                        @if($no == '1')
                                                            <strong>No</strong>
                                                        @endif
                                                        <textarea name="no_description_detail[]" id="no_description_detail{{ $no }}" rows="1" class="form-control">{{ $no }}</textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                        @if($no == '1')
                                                            <strong>Uraian</strong>
                                                        @endif
                                                        <textarea name="description[]" id="description{{ $no }}" rows="1" class="form-control">{{ $row->description }}</textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                        @if($no == '1')
                                                            <strong>Spesifikasi</strong>
                                                        @endif
                                                        <textarea name="spek[]" id="spek{{ $no }}" rows="1" class="form-control">{{ $row->spesifikasi }}</textarea>
                                                    </div>
                                                    <div class="col-md-1 qty" id="qty">
                                                        @if($no == '1')
                                                            <strong>Jumlah</strong>
                                                        @endif
                                                        <input class="form-control" type="text" name="qty[]" id="qty{{ $no }}" style="text-align: right;" value="{{ $row->qty }}" onchange="jumlah( {{ $no }} );"/>
                                                    </div>
                                                    <div class="col-md-2 price" id="price">
                                                        @if($no == '1')
                                                            <strong>Harga</strong>
                                                        @endif
                                                        <input class="form-control" type="text" name="price[]" id="price{{ $no }}" style="text-align: right;" value="{{ number_format($row->harga) }}" onchange="jumlah( {{ $no }} );"/>
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if($no == '1')
                                                            <strong>Total Harga</strong>
                                                        @endif
                                                        <input class="form-control" type="text" name="total_price[]" id="total_price{{ $no }}" style="text-align: right;" value="{{ number_format($row->tharga) }}" />
                                                    </div>
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                    <?php $no++ ?>
                                    @empty
                                                
                                    @endforelse

                                    <br>
                                    
                                    <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse ($data_upload as $row)
                                                <tr>
                                                    <td><i>Attachment_{{ $no }}</i></td>
                                                    <td>
                                                        <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                            {{ $row->filename }}
                                                        </a>        
                                                    </td>
                                                    <td>
                                                        <input type="file" class="form-control" name="filename[]" id="filename{{ $no }}">   
                                                    </td>
                                                </tr>
                                                <?php $no++ ?>
                                            @empty
                                            <tr>
                                                {{-- <td colspan="2" class="text-center">Tidak file yang di lampirkan</td> --}}
                                                <div class="row">
                                                    <div class="col-md-11 mb-2">
                                                        <strong>Lampiran/Attachment</strong>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" name="filename[]" id="filename_1" multiple>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-danger" id="button_hapus_lampiran" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                                            </span>
                                                        </div>
                                                    </div>                                       
                                                </div>
                                            </tr>   
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <strong>Tambah Lampiran/Attachment</strong>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control mr-1 col-2" name="filename_tambah[]" id="file_input" multiple>
                                                                <div type="file" id="fileList" class="form-control col-10 d-flex "></div>
                                                                
                                                            </div>
                                                        </div>                                       
                                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-7 mb-2" hidden>
                                            <a class="btn btn-success" href="javascript:void(0);" id="add_button" title="Add field">Tambah</a>
                                        </div>
                                        <div class="col-md-9 mb-2" align="right">
                                            <strong>T o t a l</strong>
                                        </div>
                                        <div class="col-md-2 mb-2" align="right">
                                            <input type="text" name="total" id="total" class="form-control" value="{{ number_format($data_total) }}" style="text-align:right; font-style:bold;" required readonly>
                                        </div>
                                        <div class="col-md-1 mb-2" align="right">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                           
                        </div>
                </div>
            </form>
        </div>
    </div>
</main>


@endsection

@section('script')



@endsection




