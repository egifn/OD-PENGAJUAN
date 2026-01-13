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
    // Mengambil data bank dengan AJAX saat jumlah bank diklik
    document.querySelectorAll('.toggle-banks').forEach(function(button) {
        button.addEventListener('click', function() {
            var perusahaanId = this.getAttribute('data-perusahaan-id');
            var bankList = document.getElementById('banks-' + perusahaanId);
            
            if(bankList){
                // Toggle visibility
                if (bankList.style.display === '' || bankList.style.display === 'none') {
                    // Memuat data bank dari server dengan AJAX
                    fetch('bod_bank/get-banks/' + perusahaanId)
                    .then(response => response.json())
                    .then(data => {
                        var listContainer = document.getElementById('bank-list-' + perusahaanId);
                        
                        listContainer.innerHTML = ''; // Kosongkan list sebelumnya

                        // Jika ada bank, tampilkan dalam list
                        if (data.length > 0) {
                            data.forEach(function(bank) {
                                var row = document.createElement('tr');
                                row.classList.add('bank-row-' + bank.kode_bank);
                                
                                var kdBankCell = document.createElement('td');
                                kdBankCell.textContent = bank.kode_bank;

                                // Menyembunyikan kolom kdBankCell
                                kdBankCell.style.display = 'none';

                                row.appendChild(kdBankCell);

                                var bankCell = document.createElement('td');
                                bankCell.textContent = bank.nama_bank;
                                row.appendChild(bankCell);

                                // Kolom Jumlah Rekening
                                var rekeningCell = document.createElement('td');
                                rekeningCell.innerHTML = '<a href="javascript:void(0)" class="toggle-rekenings" data-perusahaan-id="' + perusahaanId + '" data-bank-id="' + bank.kode_bank + '">' + bank.jml_rekening + ' Rekening</a>';
                                row.appendChild(rekeningCell);
                                
                                listContainer.appendChild(row);
                            });
                        } else {
                            // Tampilkan pesan jika tidak ada bank
                            var row = document.createElement('tr');
                            var cell = document.createElement('td');
                            cell.textContent = 'Tidak ada bank terkait';
                            row.appendChild(cell);
                            row.appendChild(cell.cloneNode(true));
                            listContainer.appendChild(row);
                        }

                        // Tampilkan row daftar bank
                        bankList.style.display = 'table-row';
                    });
                } else {
                    bankList.style.display = 'none'; 
                }
            }
        });
    });

    //======list No Rekening=================//
    // Mengambil data rekening dengan AJAX saat jumlah rekening diklik
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('toggle-rekenings')) {
            var perusahaanId = e.target.getAttribute('data-perusahaan-id');
            var bankId = e.target.getAttribute('data-bank-id');
            var rekeningList = document.getElementById('rekening-list-' + perusahaanId + '-' + bankId);
            
            var bankIdFormatted = bankId
            if (!rekeningList) {
                var newRekeningList = document.createElement('table');
                newRekeningList.classList.add('rekening-list');
                newRekeningList.id = 'rekening-list-' + perusahaanId + '-' + bankIdFormatted;
                newRekeningList.style.display = 'none'; // Awalnya disembunyikan

                // Menambahkan header
                var headerRow = document.createElement('tr');
                
                // Kolom No Rekening
                var headerCell = document.createElement('th');
                headerCell.textContent = 'No Rekening';
                headerRow.appendChild(headerCell);
                // Kolom Keterangan
                var keteranganHeaderCell = document.createElement('th');
                keteranganHeaderCell.textContent = 'Keterangan';
                headerRow.appendChild(keteranganHeaderCell);
                // Kolom Fungsi Rekening
                var fungsiRekHeaderCell = document.createElement('th');
                fungsiRekHeaderCell.textContent = 'Fungsi Rekening';
                headerRow.appendChild(fungsiRekHeaderCell);
                // Kolom Internet Banking
                var internetBankingHeaderCell = document.createElement('th');
                internetBankingHeaderCell.textContent = 'Internet Banking';
                headerRow.appendChild(internetBankingHeaderCell);
                // Kolom Token
                var tokenHeaderCell = document.createElement('th');
                tokenHeaderCell.textContent = 'Token';
                headerRow.appendChild(tokenHeaderCell);
                //kolom Cheque
                var chequeHeaderCell = document.createElement('th');
                chequeHeaderCell.textContent = 'Cheque';
                headerRow.appendChild(chequeHeaderCell);
                // Kolom Pemegang Token Viewer
                var viewerHeaderCell = document.createElement('th');
                viewerHeaderCell.textContent = 'Jml Viewer';
                headerRow.appendChild(viewerHeaderCell);
                // Kolom Pemegang Token Maker
                var makerHeaderCell = document.createElement('th');
                makerHeaderCell.textContent = 'Jml Maker';
                headerRow.appendChild(makerHeaderCell);
                // Kolom Pemegang Token Verifier
                var verifierHeaderCell = document.createElement('th');
                verifierHeaderCell.textContent = 'Jml Verifier';
                headerRow.appendChild(verifierHeaderCell);
                // Kolom Pemegang Token Authorizer
                var authorizerHeaderCell = document.createElement('th');
                authorizerHeaderCell.textContent = 'Jml Authorizer';
                headerRow.appendChild(authorizerHeaderCell);

                newRekeningList.appendChild(headerRow);

                // Menambahkan tabel rekening di bawah baris bank yang diklik
                var bankRow = document.querySelector('#banks-' + perusahaanId + ' .bank-row-' + bankIdFormatted);
                if (!bankRow) {
                    console.log('Baris bank tidak ditemukan untuk bank ' + bankId);
                    return; // Jika tidak ditemukan, stop eksekusi
                }
                
                // Menyisipkan tabel rekening setelah baris bank
                bankRow.insertAdjacentElement('afterend', newRekeningList);
                rekeningList = newRekeningList; // Referensi ke tabel rekening
            }

            // Menampilkan atau menyembunyikan tabel rekening
            if (rekeningList.style.display === 'none') {
                // Ambil data rekening dari server
                fetch('/bod_bank/get-rekenings/' + perusahaanId + '/' + bankIdFormatted)
                    .then(response => response.json())
                    .then(data => {
                        var listContainer = rekeningList.querySelector('tbody');
                        if (!listContainer) {
                            listContainer = document.createElement('tbody');
                            rekeningList.appendChild(listContainer); // Tambahkan tbody ke rekening list
                        }

                        listContainer.innerHTML = ''; // Kosongkan data lama

                        // Menampilkan rekening jika ada
                        if (data.length > 0) {
                            data.forEach(function (rekening) {
                                var row = document.createElement('tr');
                                
                                // No Rekening
                                var rekeningCell = document.createElement('td');
                                rekeningCell.textContent = rekening.norek;
                                row.appendChild(rekeningCell);

                                // Keterangan
                                var keteranganCell = document.createElement('td');
                                keteranganCell.textContent = rekening.keterangan || '-'; // Menampilkan '-' jika data kosong
                                row.appendChild(keteranganCell);

                                // Fungsi Rekening
                                var fungsiRekCell = document.createElement('td');
                                fungsiRekCell.textContent = rekening.fungsi_rek || '-'; // Menampilkan '-' jika data kosong
                                row.appendChild(fungsiRekCell);

                                // Internet Banking
                                var internetBankingCell = document.createElement('td');
                                internetBankingCell.textContent = rekening.internet_banking || '-'; // Menampilkan '-' jika data kosong
                                row.appendChild(internetBankingCell);

                                // Token
                                var tokenCell = document.createElement('td');
                                tokenCell.textContent = rekening.token || '-'; // Menampilkan '-' jika data kosong
                                row.appendChild(tokenCell);

                                // Cheque
                                var chequeCell = document.createElement('td');
                                chequeCell.textContent = rekening.cheque || '-';
                                row.appendChild(chequeCell);

                                // Jumlah Pemegang Token Viewer
                                var viewerCell = document.createElement('td');
                                //viewerCell.textContent = rekening.jml_pemegang_token_viewer || '0'; // Menampilkan 0 jika data kosong
                                viewerCell.innerHTML = '<a href="javascript:void(0)" class="toggle-viewers" data-perusahaan-id="' + perusahaanId + '" data-bank-id="' + bankIdFormatted + '">' + rekening.jml_pemegang_token_viewer + ' Pemegang</a>';
                                row.appendChild(viewerCell);

                                // Jumlah Pemegang Token Maker
                                var makerCell = document.createElement('td');
                                //makerCell.textContent = rekening.jml_pemegang_token_maker || '0'; // Menampilkan 0 jika data kosong
                                makerCell.innerHTML = '<a href="javascript:void(0)" class="toggle-makers" data-perusahaan-id="' + perusahaanId + '" data-bank-id="' + bankIdFormatted + '">' + rekening.jml_pemegang_token_maker + ' Pemegang</a>';
                                row.appendChild(makerCell);

                                // Jumlah Pemegang Token Verifier
                                var verifierCell = document.createElement('td');
                                //verifierCell.textContent = rekening.jml_pemegang_token_verifier || '0'; // Menampilkan 0 jika data kosong
                                verifierCell.innerHTML = '<a href="javascript:void(0)" class="toggle-verifiers" data-perusahaan-id="' + perusahaanId + '" data-bank-id="' + bankIdFormatted + '">' + rekening.jml_pemegang_token_verifier + ' Pemegang</a>';
                                row.appendChild(verifierCell);

                                // Jumlah Pemegang Token Authorizer
                                var authorizerCell = document.createElement('td');
                                //authorizerCell.textContent = rekening.jml_pemegang_token_authorizer || '0'; // Menampilkan 0 jika data kosong
                                authorizerCell.innerHTML = '<a href="javascript:void(0)" class="toggle-autorizers" data-perusahaan-id="' + perusahaanId + '" data-bank-id="' + bankIdFormatted + '">' + rekening.jml_pemegang_token_autorizer + ' Pemegang</a>';                                
                                row.appendChild(authorizerCell);

                                listContainer.appendChild(row);
                            });
                        } else {
                            var row = document.createElement('tr');
                            var cell = document.createElement('td');
                            cell.textContent = 'Tidak ada rekening terkait';
                            row.appendChild(cell);
                            listContainer.appendChild(row);
                        }

                        // Tampilkan tabel rekening
                        rekeningList.style.display = 'table'; // Menampilkan tabel
                    });
            } else {
                // Sembunyikan tabel rekening jika sudah terbuka
                rekeningList.style.display = 'none';
            }
        }     
    });

    document.addEventListener('click', function(e) {
        if(e.target && (e.target.classList.contains('toggle-viewers') || e.target.classList.contains('toggle-makers') || e.target.classList.contains('toggle-verifiers') || e.target.classList.contains('toggle-autorizers')))
        {
            var perusahaanId = e.target.getAttribute('data-perusahaan-id');
            var bankId = e.target.getAttribute('data-bank-id');
            //var role = e.target.getAttribute('data-role');

            var penggunaList = document.getElementById('pengguna-list-' + perusahaanId + '-' + bankId);

            if(!penggunaList){
                var newPenggunaList = document.createElement('table');
                newPenggunaList.classList.add('pengguna-list');
                newPenggunaList.id = 'pengguna-list-' + perusahaanId + '-' + bankId;
                newPenggunaList.style.display = 'none';

                var headerRow = document.createElement('tr');
                
                var headerCell = document.createElement('th');
                headerCell.textContent = 'Pemegang Viewer';
                headerRow.appendChild(headerCell);

                var headerCell = document.createElement('th');
                headerCell.textContent = 'Pemegang Maker';
                headerRow.appendChild(headerCell);

                var headerCell = document.createElement('th');
                headerCell.textContent = 'Pemegang Verifier';
                headerRow.appendChild(headerCell);

                var headerCell = document.createElement('th');
                headerCell.textContent = 'Pemegang Authorizer';
                headerRow.appendChild(headerCell);

                newPenggunaList.appendChild(headerRow);

                var bankRow = document.querySelector('#banks-' + perusahaanId + ' .bank-row-' + bankId);
                var rekeningRow = document.querySelector('#rekening-list-' + perusahaanId + '-' + bankId);

                if (!bankRow) {
                    console.log('Baris bank tidak ditemukan untuk bank ' + bankId);
                    return;
                }

                if (rekeningRow) {
                    rekeningRow.insertAdjacentElement('afterend', newPenggunaList);
                } else {
                    bankRow.insertAdjacentElement('afterend', newPenggunaList);
                }

                penggunaList = newPenggunaList;
            }

            if (penggunaList.style.display === 'none') {
                fetch('/bod_bank/get-pemegang/' + perusahaanId + '/' + bankId)
                    .then(response => response.json())
                    .then(data => {
                        var listContainer = penggunaList.querySelector('tbody');
                        if (!listContainer) {
                            listContainer = document.createElement('tbody');
                            penggunaList.appendChild(listContainer);
                        }

                        listContainer.innerHTML = ''; // Kosongkan tabel sebelumnya

                        // Jika ada data pengguna, tampilkan
                        if (data.length > 0) {
                            data.forEach(function(pemegang) {
                                var row = document.createElement('tr');

                                var nameViewerCell = document.createElement('td');
                                nameViewerCell.textContent = pemegang.name_viewer;
                                row.appendChild(nameViewerCell);

                                var nameMakerCell = document.createElement('td');
                                nameMakerCell.textContent = pemegang.name_maker;
                                row.appendChild(nameMakerCell);

                                var nameVerifiedCell = document.createElement('td');
                                nameVerifiedCell.textContent = pemegang.name_verifier;
                                row.appendChild(nameVerifiedCell);

                                var nameautorizerCell = document.createElement('td');
                                nameautorizerCell.textContent = pemegang.name_autorizer;
                                row.appendChild(nameautorizerCell);

                                listContainer.appendChild(row);
                            });
                        } else {
                            var row = document.createElement('tr');
                            var cell = document.createElement('td');
                            cell.textContent = 'Tidak ada pengguna terkait';
                            row.appendChild(cell);
                            listContainer.appendChild(row);
                        }

                        // Menampilkan tabel pengguna
                        penggunaList.style.display = 'table';
                    });
            } else {
                penggunaList.style.display = 'none'; // Menyembunyikan tabel pengguna jika sudah ada
            }
        }
    });
</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Bank</title>
@endsection

@section('content')

<main class="main">
    <style>
        /* Tambahkan beberapa style untuk mempercantik tampilan */
        .banks-list {
            display: none;
            margin-top: 10px;
            padding-left: 20px;
        }

        .banks-list th, .banks-list td {
            padding: 8px;
        }

        .rekening-list {
            display: none;
            margin-top: 10px;
            padding-left: 60px;
            margin-left: 20px;
            margin-bottom: 10px;
        }

        .rekening-list th, .rekening-list td {
            padding: 8px;
        }

        .pengguna-list {
            display: none;
            margin-top: 10px;
            padding-left: 60px;
            margin-left: 40px;
            margin-bottom: 10px;
        }

        .pengguna-list th, .pengguna-list td {
            padding: 8px;
        }
    </style>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Vendor</li>
        <li class="breadcrumb-item active">Bank</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Bank</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif        
                                
                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>Perusahaan</th>
                                            <th>Jml Bank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_perusahaan as $perusahaan)
                                            <tr>
                                                <td>{{ $perusahaan->nama_perusahaan }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="toggle-banks" data-perusahaan-id="{{ $perusahaan->kode_perusahaan }}">
                                                        {{ $perusahaan->jml_bank }} Bank
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Row untuk menampilkan daftar bank, disembunyikan oleh default -->
                                            <tr class="banks-list" id="banks-{{ $perusahaan->kode_perusahaan }}">
                                                <td colspan="2">
                                                    <table border="1">
                                                        <thead>
                                                            <tr>
                                                                <th hidden>Kode Bank</th>
                                                                <th >Nama Bank</th>
                                                                <th >Jml Rekening</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bank-list-{{ $perusahaan->kode_perusahaan }}">
                                                            
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>         
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection