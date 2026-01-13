@section('js')

<script type="text/javascript">
    //$('#nominal').maskMoney({thousands:',', decimal:'.', precision:0});

    $(document).ready(function () {
        fetch_request_data();

        function fetch_request_data(query = '') {
            $.ajax({
                url: '{{ route("pelunasan/action_rek.actionRekening") }}',
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function (data) {
                    $('#lookup_request tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_request', function () {
            var query = $(this).val();
            fetch_request_data(query);
        });
    });

    $(document).on('click', '.pilih_rek', function (e) {
        document.getElementById("id_saldo").value = $(this).attr('data-id');
        document.getElementById("cari_data").value = $(this).attr('data-keterangan');
        let tempNominal = $(this).attr('data-kredit');
        //membuat format rupiah nominal//
        var reverse_nominal = tempNominal.toString().split('').reverse().join(''),
          ribuan_nominal  = reverse_nominal.match(/\d{1,3}/g);
          total_nominal = ribuan_nominal.join(',').split('').reverse().join('');
        //End membuat format nominal//
        document.getElementById("nominal").value = total_nominal;

        let nominal = tempNominal;
        let date_jt = document.getElementById("jt").value = $(this).attr('data-tanggal');
        $('#myModal').modal('hide');
        //$('#nominal').maskMoney({thousands:',', decimal:'.', precision:0});
        //=== Select data Toko ====//
        $.ajax({
            type: "GET",
            url: "{{ route('getDms') }}",
            data: {
                nominal: nominal,
                date_jt: date_jt
            },
            dataType: "json",
            success: function (response) {
                $("#id_pelanggan").val(response.data.szCustomerId);
                $("#nama_pelanggan").val(response.data.szName);
                $("#bank").val(response.data.nama_bank);
            }
        });
        //=== Select data Toko ====//
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
<title>Pelunasan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Pelunasan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Input Data Pelunasan</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('pelunasan/store.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                @if(Auth::user()->kode_divisi == '23')
                                <!-- Jika korsis-->

                                @else
                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-3 mb-2">

                                    </div>
                                </div>
                                @endif

                                <div class="card-body">
                                    <table>
                                        <td width="300"><input type="text" name="id_saldo" id="id_saldo"
                                                class="form-control" required hidden></td>
                                        <td width="500">
                                            <div class="input-group">
                                                <input id="cari_data" name="cari_data" type="text" class="form-control"
                                                    placeholder="--- Cari data rekening untuk pelunasan ---" readonly
                                                    required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary"
                                                        data-toggle="modal" data-target="#myModal">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                    </table>
                                    <table>
                                        <td width="300"></td>
                                        <td width="500">
                                            <hr style="border:0; height: 1px; background-color: #D3D3D3; ">
                                        </td>
                                    </table>
                                    <table>
                                        <td width="300"></td>
                                        <td width="200">Nominal</td>
                                        <td></td>
                                        <td width="300">
                                            <input type="text" name="nominal" id="nominal" class="typeahead form-control" required readonly>
                                        </td>
                                    </table>
                                    <table>
                                        <td width="300"></td>
                                        <td width="200">Jatuh Tempo</td>
                                        <td></td>
                                        <td width="300">
                                            <input type="text" name="jt" id="jt" class="form-control" required readonly>
                                        </td>
                                    </table>
                                    <table>
                                        <td width="300"></td>
                                        <td width="200">Id Pelanggan</td>
                                        <td></td>
                                        <td width="300">
                                            <input type="text" name="id_pelanggan" id="id_pelanggan" class="form-control" required readonly>
                                        </td>
                                    </table>
                                    <table>
                                        <td width="300"></td>
                                        <td width="200">Nama Pelangga</td>
                                        <td></td>
                                        <td width="300">
                                            <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" required readonly>
                                        </td>
                                    </table>
                                    <table>
                                        <td width="300"></td>
                                        <td width="200">Bank</td>
                                        <td></td>
                                        <td width="300">
                                            <input type="text" name="bank" id="bank" class="form-control" required readonly>
                                        </td>
                                    </table>
                                    <table hidden>
                                        {{-- <td width="300"></td>
                                        <td width="200">Invoice</td>
                                        <td></td>
                                        <td width="300"><input type="text" name="inv" id="inv" class="form-control" required readonly></td> --}}
                                        
                                        <td width="300"></td>
                                        <td width="200">Invoice</td>
                                        <td></td>
                                        <td width="300">
                                            <select name="cari_invoice" class="js-example-basic-single" id="cari_invoice" autofocus="autofocus" style="width: 100%; height: 34px; font-size: 14px;"></select>
                                        </td>
                                    </table>
                                    <table>
                                        <td width="300"></td>
                                        <td width="200">No. cek</td>
                                        <td></td>
                                        <td width="300">
                                            <input type="text" name="no_cek" id="no_cek" class="form-control" required>
                                        </td>
                                    </table>
                                    <br>
                                    <table>
                                        <td width="300"></td>
                                        <td width="200"></td>
                                        <td></td>
                                        <td><button class="btn btn-success btn-lm">S i m p a n</button></td>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background: #fff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Biaya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="get">
                        <div class="input-group mb-3 col-md-4 float-right">
                            <input type="text" name="cari_request" id="cari_request" class="form-control"
                                placeholder="Cari Data . . .">
                        </div>
                    </form>
                    <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                        <table id="lookup_request" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th hidden>id</th>
                                    <th>No Rekening</th>
                                    <th>tgl Transaksi</th>
                                    <th>Deskripsi</th>
                                    <th>Kredit</th>
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
</main>
@endsection
