@section('js')
<script type="text/javascript">
    $(document).on('click', '.pilih_coa', function(e) {
        document.getElementById('addCoa').value = $(this).attr('data-kode_coa')
        document.getElementById('addCoa_name').value = $(this).attr('data-coa')
        


        $('#myModalCoa').modal('hide');
    });

    $(document).ready(function(){
        fetch_coa_data();
        function fetch_coa_data(query = '')
        {
            $.ajax({
                url:'{{ route("pengeluaran/action_coa.actionCoa") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_coa tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_coa', function(){
            var query = $(this).val();
            fetch_coa_data(query);
        });
    });

</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Pengeluaran</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Pengeluaran</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Master Pengeluaran
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalTambah">
                                    <i class="nav-icon icon-plus"></i>&nbsp T a m b a h
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <!--<div style="width:400%;"> -->
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>No</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Jenis</th>
                                                <th>Peruntukan</th>
                                                <th>Sifat</th>
												<th>Kontrabon</th>
                                                <th>Keterangan</th>
												<th>Cara Pembayaran</th>
                                                <th hidden>Kategori</th>
                                                <th>COA</th>
                                                <th hidden>Input Oleh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php $no=1 ?>
                                           @forelse($m_pengeluaran as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                <td>{{ $val->sifat }}</td>
                                                <td>{{ $val->jenis }}</td>
                                                <td>{{ $val->pembayaran }}</td>
												<td>{{ $val->kontrabon }}</td>
                                                <td>{{ $val->keterangan }}</td>
												<td>{{ $val->cara_pembayaran }}</td>
                                                <td hidden>{{ $val->kategori }}</td> 
                                                <td>{{ $val->nama_transaksi }}</td>
                                                <td hidden>{{ $val->name }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data untuk saat ini</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                <!-- </div> -->
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambah" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--FORM TAMBAH BARANG-->
                <form action="{{ route('pengeluaran_simpan') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama Pengeluaran</label>
                        <input type="text" class="form-control" id="addNamaPengeluaran" name="addNamaPengeluaran" required>
                    </div>
                    <div class="form-group">
                        <label for="">Jenis</label>
                        <select id="addSifat" name="addSifat" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Rutin">Rutin</option>
                            <option value="Non Rutin">Non Rutin</option>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Peruntukan</label>
                        <select id="addJenis" name="addJenis" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Inventasi">Inventasi</option>
                            <option value="Barang">Barang</option>
                            <option value="Jasa">Jasa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Sifat</label>
                        <select id="addPembayaran" name="addPembayaran" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Kredit">Kredit</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Tunai/Kredit">Tunai/Kredit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Cara Pembayaran</label>
                        <select id="addCaraPembayaran" name="addCaraPembayaran" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Autodebet Rekening">Autodebet Rekening</option>
                            <option value="Cek/Giro - Transfer">Cek/Giro - Transfer</option>
                            <option value="Cek/Giro/Slip">Cek/Giro/Slip</option>
                            <option value="Uang Tunai">Uang Tunai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kontrabon</label>
                        <select id="addkontra" name="addkontra" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Kontrabon">Kontrabon</option>
                            <option value="Non Kontrabon">Non Kontrabon</option>
                            <option value="Kontrabon/Non Kontrabon">Kontrabon/Non Kontrabon</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <select id="addKeterangan" name="addKeterangan" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Prepaid">Prepaid</option>
                            <option value="Non Prepaid">Non Prepaid</option>
                        </select>
                    </div>
                    <div class="form-group" hidden>
                        <label for="">Kategori</label>
                        <select id="addKategori" name="addKategori" class="form-control">
                            <option value="">Pilih</option>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">COA</label>
                        <div class="input-group">
                            <input id="addCoa_name" type="text" name="addCoa_name" class="form-control" readonly>
                            <input id="addCoa" type="hidden" name="addCoa" value="" readonly>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalCoa"> <span class="fa fa-search"></span></button>
                            </span>
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                </form>
                <!--END FORM TAMBAH BARANG-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalCoa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" hidden>
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa" id="search_coa" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:510px;overflow-y:scroll;">
                    <table id="lookup_coa" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Account Id</th>
                                <th>Account Name</th>
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