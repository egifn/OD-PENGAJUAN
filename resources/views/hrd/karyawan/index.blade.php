@extends('layouts.admin')

@section('title')
    <title>Karyawan</title>
@endsection

@section('content')

<main class="main">
	<link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
	
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Karyawan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Data Karyawan
                                <a href="{{ route('karyawan/create.create') }}" class="btn btn-primary btn-sm float-right">Tambah Karyawan</a>
                            </h4>
                        </div>

                        

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="get">
                                <div class="input-group mb-3 col-md-6">  
                                    
                                    <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari Data Karyawan" value="" >

                                </div>   
                            </form>


                            
                            <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                                @csrf
								<div class="table-responsive">
                                    <table id="tblKaryawan" class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Id</th>
                                                <th>Nama Lengkap</th>
                                                <th>Alamat</th>
                                                <th>Tlp</th>
                                                <th>NIK</th>
                                                <th>ID DMS</th>
                                                <th>Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th>Depo</th>
                                                <th>Jabatan</th>
                                                <th hidden>Kode Area</th>
                                                <th>Area</th>
                                                <th>Tgl Gabung</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyKaryawan">
                                            
                                        </tbody>
                                    </table>
								</div>
                            </form>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



@endsection

@section('js')
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tbody = document.getElementById("tbodyKaryawan");
        const inputCari = document.getElementById("cari");

        let dataKaryawan = [];

        // Fetch data dari route
        fetch("{{ route('karyawan.data') }}")
            .then(res => res.json())
            .then(data => {
                dataKaryawan = data; // simpan semua data
                renderTable(dataKaryawan);
            });

        // Fungsi render data ke tabel
        function renderTable(data) {
            tbody.innerHTML = "";
            data.forEach((row, index) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td hidden>${row.id}</td>
                    <td>${row.nama}</td>
                    <td>${row.alamat}</td>
                    <td>${row.tlp}</td>
                    <td>${row.nik}</td>
                    <td>${row.id_dms}</td>
                    <td>${row.perusahaan}</td>
                    <td>${row.nama_depo}</td>
                    <td>${row.jabatan}</td>
                    <td>${row.area_name}</td>
                    <td>${row.tgl_gabung}</td>
                    <td>${row.status ?? '-'}</td>
                    <td>
                        <a href="/karyawan/${row.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Event pencarian
        inputCari.addEventListener("keyup", function () {
            const keyword = this.value.toLowerCase();
            const filtered = dataKaryawan.filter(row => 
                row.nama.toLowerCase().includes(keyword) ||
                row.alamat.toLowerCase().includes(keyword) ||
                row.tlp.toLowerCase().includes(keyword) ||
                row.nik.toLowerCase().includes(keyword) ||
                row.perusahaan.toLowerCase().includes(keyword) ||
                row.nama_depo.toLowerCase().includes(keyword) ||
                row.area_name.toLowerCase().includes(keyword)
            );
            renderTable(filtered);
        });
    });
</script>


    

@endsection


