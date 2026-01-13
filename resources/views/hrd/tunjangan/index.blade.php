@extends('layouts.admin')

@section('title')
    <title>Tunjangan</title>
@endsection

@section('content')

<main class="main">
	<link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
	
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Tunjangan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Tunjangan
                                <a href="{{ route('tunjangan/create.create') }}" class="btn btn-primary btn-sm float-right">Tambah Tunjangan</a>
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
                                    
                                    <input type="hidden" id="cari" name="cari" class="form-control" placeholder="Cari Data" value="" >

                                </div>   
                            </form>


                            
                            <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                                @csrf
								<div class="table-responsive">
                                    <table id="tblTunjangan" class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Id</th>
                                                <th>Nama Tunjangan</th>
                                                <th>Nilai</th>
                                                <th hidden>Status</th>
                                                <th hidden>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyTunjangan">
                                            
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
        const tbody = document.getElementById("tbodyTunjangan");
        const inputCari = document.getElementById("cari");

        let dataTunjangan = [];

        // Fetch data dari route
        fetch("{{ route('tunjangan.data') }}")
            .then(res => res.json())
            .then(data => {
                dataTunjangan = data; // simpan semua data
                renderTable(dataTunjangan);
            });

        // Fungsi render data ke tabel
        function renderTable(data) {
            tbody.innerHTML = "";
            data.forEach((row, index) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td hidden>${row.id}</td>
                    <td>${row.nama_tunjangan}</td>
                    <td align="right">Rp ${Number(row.nilai).toLocaleString('id-ID')}</td>
                    <td hidden>${row.status ?? '-'}</td>
                    <td align="center" hidden>
                        <a href="/tunjangan/${row.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Event pencarian
        inputCari.addEventListener("keyup", function () {
            const keyword = this.value.toLowerCase();
            const filtered = dataTunjangan.filter(row => 
                row.nama.toLowerCase().includes(keyword) ||
                row.nilai.toLowerCase().includes(keyword)
            );
            renderTable(filtered);
        });
    });
</script>


    

@endsection


