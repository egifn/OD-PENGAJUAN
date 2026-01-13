{{-- @section('js')
<script type="text/javascript">
    
</script>
@stop --}}


@extends('layouts.admin')

@section('title')
    <title>Data Pelunasan</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Data Pelunasan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Data Yang akan di payment
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pelunasan/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <form action="{{ route('pelunasan/kirim.kirim') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                                <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    
                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>id</th>
                                                    <th>tanggal</th>
                                                    <th>No Cek</th>
                                                    <th>Nominal</th>
                                                    <th>Jatuh Tempo</th>
                                                    <th>Id Pelanggan</th>
                                                    <th>Nama Pelanggan</th>
                                                    <th>Bank</th>
                                                    @if(Auth::user()->kode_divisi == '24') <!-- Piutang --> 
                                                        <th hidden>Status Cek</th>
                                                        <th>Action</th>
                                                    @elseif(Auth::user()->kode_divisi == '25') <!-- Kasir --> 
                                                        <th>Status Cek</th>
                                                        <th>Pilih</th>
                                                    @else
                                                        <th>Status Cek</th>
                                                    @endif
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @forelse($pelunasan as $val)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td hidden>
                                                        <input type="text" class="form-control" name="id[]" id="id" style="font-size: 13px;" value="{{ $val->id }}" hidden>
                                                        {{ $val->id }}
                                                    </td>
                                                    <td>{{ $val->tanggal }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="no_cek[]" id="no_cek" style="font-size: 13px;" value="{{ $val->no_cek }}" hidden>
                                                        {{ $val->no_cek }}
                                                    </td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="nominal[]" id="nominal" style="font-size: 13px;" value="{{ $val->nominal }}" hidden>
                                                        {{ number_format($val->nominal) }}
                                                    </td>
                                                    <td align="center">
                                                        <input type="text" class="form-control" name="jt[]" id="jt" style="font-size: 13px;" value="{{ $val->jatuh_tempo }}" hidden>
                                                        {{ $val->jatuh_tempo }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="id_pelanggan[]" id="id_pelanggan" style="font-size: 13px;" value="{{ $val->id_pelanggan }}" hidden>
                                                        {{ $val->id_pelanggan }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="nama_pelanggan[]" id="nama_pelanggan" style="font-size: 13px;" value="{{ $val->nama_pelanggan }}" hidden>
                                                        {{ $val->nama_pelanggan }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="bank[]" id="bank" style="font-size: 13px;" value="{{ $val->bank }}" hidden>
                                                        {{ $val->bank }}
                                                    </td>
                                                    @if(Auth::user()->kode_divisi == '24') <!-- Piutang --> 
                                                        <td hidden>{{ $val->status_cek }}</td>
                                                        <td align="center">
                                                            <button type="button" data-id="{{ $val->id }}" id="button_edit" class="btn btn-warning btn-sm">Ubah</button>
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '25') <!-- Kasir --> 
                                                        <td>
                                                            <input type="text" class="form-control" name="status_cek[]" id="status_cek" style="font-size: 13px;" value="{{ $val->status_cek }}" hidden>
                                                            {{ $val->status_cek }}
                                                        </td>
                                                        <td align="center"><input type="checkbox" name="chk{{ $no }}" id="chk{{ $no }}"  value="1" /></td>
                                                    @else
                                                        <td>{{ $val->status_cek }}</td>
                                                    @endif
                                                </tr>
                                                <?php $no++ ?>
                                                @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" align="center" bgcolor="#E6E6E6"><b>Total<b></td>
                                                    <td colspan="1" align="right" bgcolor="#E6E6E6"><b>Rp. {{ number_format($total->total) }}<b></td>
                                                    <td colspan="7" align="center" bgcolor="#E6E6E6">
                                                        
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                </div>

                                @if(Auth::user()->kode_divisi == '25') <!-- Piutang --> 
                                <br>
                                <div class="row">                  
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-primary btn-sm float-right">K i r i m</button>
                                    </div> 
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Modal Edit Data -->
                <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEdit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ubah Data Pelunasan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!--FORM TAMBAH BARANG-->
                                <form>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="id_saldo" name="id_saldo" value="" required readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Deskripsi</label>
                                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nominal</label>
                                        <input type="text" class="form-control" id="nominal" name="nominal" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jatuh Tempo</label>
                                        <input type="text" class="form-control" id="jt" name="jt" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Id Pelanggan</label>
                                        <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nm_pelanggan" name="nm_pelanggan" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Bank</label>
                                        <input type="text" class="form-control" id="bank" name="bank" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">No Cek</label>
                                        <input type="text" class="form-control" id="no_cek" name="no_cek" required>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm float-right" id="button_form_update" data-dismiss="modal">S i m p a n</button>
                                    
                                </form>
                                <!--END FORM TAMBAH BARANG-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Edit Data -->


            </div>
        </div>
    </div>
</main>


@endsection

@section('js')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        
        $(document).ready(function() {
           

            //INISIASI DATERANGEPICKER
            $('#tanggal').daterangepicker({
               
            })

            
        })
    </script>

    <script type="text/javascript">
        $('#savedatas').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("pelunasan/kirim.kirim") }}',
                type: 'post',
                data: $(this).serializeArray(),
                success: function(data){
                    console.log(data);
                }
            });
        });

        //Edit data//
        $(document).on("click", "#button_edit", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ route('getDetailDataPayment') }}",
                data: {
                    id:id
                },
                dataType: "json",
                success: function(response) {
                    $('#id_saldo').val(id);
                    $('#deskripsi').val(response.data.description);
                    $('#nominal').val(response.data.nominal);
                    $('#jt').val(response.data.jatuh_tempo);
                    $('#id_pelanggan').val(response.data.id_pelanggan);
                    $('#nm_pelanggan').val(response.data.nama_pelanggan);
                    $('#bank').val(response.data.bank);
                    $('#no_cek').val(response.data.no_cek);
                }
            });
            $('#modalEdit').modal('show');
        });
        
        $("#button_form_update").click(function() {
            let id_saldo = $('#id_saldo').val();
            let deskripsi = $('#deskripsi').val();
            let nominal = $('#nominal').val();
            let jt = $('#jt').val();
            let id_pelanggan = $('#id_pelanggan').val();
            let nm_pelanggan = $('#nm_pelanggan').val();
            let bank = $('#bank').val();
            let no_cek = $('#no_cek').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "#",
                data: {
                    id_saldo: id_saldo,
                    deskripsi: deskripsi,
                    nominal: nominal,
                    jt: jt,
                    id_pelanggan: id_pelanggan,
                    nm_pelanggan: nm_pelanggan,
                    bank: bank,
                    no_cek: no_cek,
                },
                success: function(response) {
                    if (response.status === true) {
                        $('#modalEdit').modal('hide');
                        // Swal.fire("Sukses!", `${response.message}`, "success");
                        alert('Sukses, Data Berhasil diubah...');
                        //fetchAll();
                    }else{
                        alert('Gagal, Data tidak berhasil diubah...');
                    }
                }
            });
        });
        //end Edit data//


    </script>



@endsection