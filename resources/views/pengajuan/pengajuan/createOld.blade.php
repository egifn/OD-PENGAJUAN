@section('js')
<script type="text/javascript">
   $(document).on('click', '.pilih', function (e) {
                
                var tabel = document.getElementById("tabelinput");
                var row = tabel.insertRow(1);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);

                var a = $(this).attr('data-kode_produk');
                var b = $(this).attr('data-nama_produk');
                var c = $(this).attr('data-merk');
                var d = $(this).attr('data-ket');
               
                cell1.innerHTML = '<input name="chk" type="checkbox" />';
                cell2.innerHTML = a;
                cell3.innerHTML = b;
                cell4.innerHTML = c;
                cell5.innerHTML = d;
                cell6.innerHTML = '<input type="number" name="text1[]" style="width: 50px; font-size: 13px; text-align: right;" >';

                $('#myModal').modal('hide');
    });

    
    $(function () {
                $("#lookup").dataTable();
    });

    function hapusbaris(tabel){
        var tabel = document.getElementById("tabelinput");
        var bacabaris = tabel.rows.length;
        for(var i=0;i<bacabaris;i++){
            //baca baris yang ke i
            var bacabarisyangke = tabel.rows[i];
            //baca ceklist di childnode cell ke 0
            var bacaceklist = bacabarisyangke.cells[0].childNodes[0];
            //jika ada ceklist
            if(null != bacaceklist && true == bacaceklist.checked){
                tabel.deleteRow(i);
                bacabaris--;
                i--;
            }
        }
        return false;
        }
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Tambah Pengajuan</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">Tambah Pengajuan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="kode">Kode Pengajuan</label>
                                        <input type="text" name="kode" class="form-control" value="{{ $kode }}" required readonly>
                                        <p class="text-danger">{{ $errors->first('kode') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="tgl">Tanggal Pengajuan</label>
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                        <p class="text-danger">{{ $errors->first('tgl') }}</p>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="nama">Nama Pemohon</label>
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                        <p class="text-danger">{{ $errors->first('kode') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="kode_perusahaan">Perusahaan</label>
                                        <select name="kode_perusahaan" class="form-control">
                                            <option value="">Pilih</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                        <p class="text-danger">{{ $errors->first('kode_perusahaan') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kode_depo">Depo</label>
                                        <select name="kode_depo" class="form-control">
                                            <option value="">Pilih</option>
                                            @foreach ($depo as $row)
                                                <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected':'' }}>{{ $row->nama_depo }}</option>
                                            @endforeach 
                                        </select>
                                        <p class="text-danger">{{ $errors->first('kode_depo') }}</p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="kode_divisi">Divisi</label>
                                        <select name="kode_divisi" class="form-control">
                                            <option value="">Pilih</option>
                                            @foreach ($divisi as $row)
                                                <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                            @endforeach 
                                        </select>
                                        <p class="text-danger">{{ $errors->first('kode_divisi') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="jenis">Jenis Pengajuan</label>
                                        <select name="jenis" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="Rutin">Rutin</option>
                                            <option value="Non Rutin">Non Rutin</option>
                                        </select>
                                        <p class="text-danger">{{ $errors->first('jenis') }}</p>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="ket">Keterangan</label>
                                        <input type="text" name="ket" class="form-control">
                                        <p class="text-danger">{{ $errors->first('ket') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

<!-- ################################### TUTUP SEMENTARA #################################### -->
                
                    <div class="col-md-8">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Pengajuan Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:320px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kode Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Keterangan/Spek</th>
                                                    <th>Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Produk</button>
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Produk</button>
                                    </div> 
                                    <div class="col-md-8 mb-2">
                                        <button class="btn btn-primary btn-sm float-right">Simpan Pengajuan</button>
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Merk</th>
                            <th>Keterangan/Spek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $data)
                        <tr class="pilih" data-kode_produk="<?php echo $data->kode; ?>" data-nama_produk="<?php echo $data->nama_barang; ?>" data-merk="<?php echo $data->merk; ?>" data-ket="<?php echo $data->ket; ?>">
                            <td><strong>{{$data->kode}}</strong></td>
                            <td>{{$data->nama_barang}}</td>
                            <td>{{$data->merk}}</td>
                            <td>{{$data->ket}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')



@endsection


