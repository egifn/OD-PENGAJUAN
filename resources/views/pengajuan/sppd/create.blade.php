@section('js')
<script type="text/javascript">
    $(document).on('click', '.pilih_category', function(e){
        document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
        document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
        document.getElementById('sifat').value = $(this).attr('data-sifat')
        document.getElementById('jenis').value = $(this).attr('data-jenis')
        document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')
        
        $('#myModalKategori').modal('hide');
    });
    
    $(function(){
        // $('#kode_perusahaan_tujuan_1').change(function(){
        //     var perusahaan_id_tujuan = $(this).val();
        //     if(perusahaan_id_tujuan){
        //         $.ajax({
        //             type:"GET",
        //             url:"/ajax_depo_tujuan?perusahaan_id_tujuan="+perusahaan_id_tujuan,
        //             dataType:'JSON',
        //             success: function(res){
        //                 if(res){
        //                     $("#kode_depo_tujuan_1").empty();
        //                     $("#kode_depo_tujuan_1").append('<option value="">Pilih</option>');
        //                     $.each(res,function(nama,kode){
        //                         $("#kode_depo_tujuan_1").append('<option value="'+kode+'">'+nama+'</option>');
        //                     });
        //                 }else{
        //                     $("#kode_depo_tujuan_1").empty();
        //                 }
        //             }
        //         });
        //     }else{
        //         $("#kode_depo_tujuan_1").empty();
        //     }
        // });
    });

    

    $(document).ready(function(){
        fetch_data_category();
        function fetch_data_category(query = '')
        {
            $.ajax({
                url:'{{ route("sppd/action_category.actionCategory") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_category tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_category', function(){
            var query = $(this).val();
            fetch_data_category(query);
        });
    });

    $(document).ready(function(){
              
        var addButton = $('#add_button'); 
        var wrapper = $('.field_wrapper'); 
        var x = 1; 
        $(addButton).click(function(){
            x++;    
            $(wrapper).append('<div class="form-group add"><hr><div class="row"><div class="col-md-3 mb-2">Tujuan/Lokasi Perusahaan <select name="kode_perusahaan_tujuan[]" id="kode_perusahaan_tujuan_'+x+'" class="form-control" required><option value="">select</option>@foreach ($perusahaan as $row)<option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>@endforeach </select></div><div class="col-md-3 mb-">Tujuan/Lokasi Depo<select name="kode_depo_tujuan[]" id="kode_depo_tujuan_'+x+'" class="form-control"><option value="">select</option></select></div><div class="col-md-2 mb-2">Lama Tugas (dari)<input type="date" name="lama_tugas[]" id="lama_tugas_'+x+'" class="form-control" value="" required></div><div class="col-md-2 mb-2">(sampai)<input type="date" name="sampai[]" id="sampai_'+x+'" class="form-control" value="" required></div><div class="col-md-10 mb-2">Keperluan Tugas<textarea name="keperluan[]" id="keperluan_'+x+'" value="" rows="1" class="form-control"></textarea></div><div class="col-md-2" align="right"><br><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="nav-icon icon-trash"></i></a></div></div></div>');
        });

        $(wrapper).on('change', '[name^="kode_perusahaan_tujuan"]', function() {
            // var selectedValue = $(this).val();
            // // Add your logic to display message based on selectedValue
            // alert("Anda memilih perusahaan dengan kode: " + selectedValue);

            // $('#kode_perusahaan_tujuan_1').change(function(){
                var perusahaan_id_tujuan = $(this).val();
                if(perusahaan_id_tujuan){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo_tujuan?perusahaan_id_tujuan="+perusahaan_id_tujuan,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#kode_depo_tujuan_"+x+"").empty();
                                $("#kode_depo_tujuan_"+x+"").append('<option value="">Pilih</option>');
                                $.each(res,function(nama,kode){
                                    $("#kode_depo_tujuan_"+x+"").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#kode_depo_tujuan_"+x+"").empty();
                            }
                        }
                    });
                }else{
                    $("#kode_depo_tujuan_"+x+"").empty();
                }
            // });            

        });

        $(wrapper).on('click', '.remove_button', function(e){
                if (confirm("Apakah anda yakin mau menghapus baris ini?")) {
                    e.preventDefault();
                    $(this).parent('').parent('').remove(); 
                    x--; 
                }
                
        });
    });

</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Create SPPD</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item">SPPD</li>
        <li class="breadcrumb-item active">Create SPPD</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('sppd.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Create SPPD</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Divisi/Jabatan
                                        <input type="text" name="kode_divisi" class="form-control" value="{{ $data->kode_divisi }}" required readonly hidden>
                                        <input type="text" name="divisi" class="form-control" value="{{ $data->nama_divisi }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" class="form-control" value="{{ $data->kode_perusahaan}}" required readonly hidden>
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $data->nama_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Depo
                                        <input type="text" name="kode_depo" class="form-control" value="{{ $data->kode_depo }}" required readonly hidden>
                                        <input type="text" name="depo" class="form-control" value="{{ $data->nama_depo }}" required readonly>
                                    </div>
                                </div>

                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Pelaksana Tugas
                                        <input type="text" name="id" class="form-control" value="{{ $data->id }}" required readonly hidden>
                                        <input type="text" name="pelaksana" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Kendaraan yg digunakan
                                        <select name="kendaraan" id="kendaraan" class="form-control" required>
                                            <option value="">Pilih</option>
                                            <option value="Mobil">Mobil</option>
                                            <option value="Motor">Motor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Sebagai
                                        <select name="sebagai" id="sebagai" class="form-control" required>
                                            <option value="">Pilih</option>
                                            <option value="Pengemudi">Pengemudi</option>
                                            <option value="Pengikut">Pengikut</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="field_wrapper">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            Tujuan/Lokasi Perusahaan
                                            <select name="kode_perusahaan_tujuan[]" id="kode_perusahaan_tujuan_1" class="form-control" required>
                                                <option value="">select</option>
                                                @foreach ($perusahaan as $row)
                                                    <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                                @endforeach 
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-">
                                            Tujuan/Lokasi Depo
                                            <select name="kode_depo_tujuan[]" id="kode_depo_tujuan_1" class="form-control">
                                                <option value="">select</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            Lama Tugas (dari)
                                            <input type="date" name="lama_tugas[]" id="lama_tugas_1" class="form-control" value="" required>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            (sampai)
                                            <input type="date" name="sampai[]" id="sampai_1" class="form-control" value="" required>
                                        </div>

                                        <div class="col-md-10 mb-2">
                                            Keperluan Tugas
                                            <textarea name="keperluan[]" id="keperluan_1" rows="1" class="form-control"></textarea>
                                        </div>

                                        


                                        <div class="col-md-1 mb-2"></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <div class="input-group">
                                            <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" value="34" required >
                                            <input id="nama_pengeluaran" type="text" class="form-control" value="SPPD (Perjalanan Dinas)" readonly required>
                                            <input id="sifat" type="hidden" name="sifat" class="form-control"  required>
                                            <input id="jenis" type="hidden" name="jenis" class="form-control"  required>
                                            <input id="pembayaran" type="hidden" name="pembayaran" class="form-control"  required>
                                            <input id="kategori" type="hidden" name="kategori" class="form-control"  required>
                                            <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran" class="form-control"  required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <br>
                                        <a class="btn btn-primary" href="javascript:void(0);" id="add_button" title="Add field">Tambah</a>
                                    </div>

                                    <div class="col-md-8 mb-2" align="right">
                                        <br>
                                        <button class="btn btn-success">Buat SPPD</button>
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

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_category" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Pengeluaran</th>
                                <th>Sifat</th>
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

@section('script')



@endsection




