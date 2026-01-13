@section('js')

@stop

@extends('layouts.admin')

@section('title')
    <title>Produk</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Produk</li>
        <li class="breadcrumb-item active">Produk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Produk
                                <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm float-right">Tambah Produk Baru</a>

                                <a href="{{ route('product_import.index') }}" class="btn btn-warning btn-sm float-right" hidden>Import Data</a>

                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('product.index') }}" method="get">
                                <div class="input-group mb-2 col-md-6 float-right">
                                    <input type="text" name="q" class="form-control" placeholder="Cari Produk..." value="{{ request()->q }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Id</th>
                                                <th>Produk</th>
                                                <th>Merk</th>
                                                <th>Unit</th>
                                                <th>Stok</th>
                                                <th>Harga</th>
                                                <th>Kategori</th>
                                                <th>Tgl Input</th>
                                                <th>User Input</th>
                                                <th hidden>Tanggal Ubah</th>
                                                <th hidden>User Ubah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($product as $val)
                                            <tr>
                                                <td>{{ $val->kode }}</td>
                                                <td>{{ $val->nama_barang }}</td>
                                                <td>{{ $val->merk }}</td>
                                                <td>{{ $val->satuan }}</td>
                                                <td align="right">{{ $val->stock }}</td>
                                                <td align="right">{{ number_format($val->price) }}</td>
                                                <td>{{ $val->kategori }}</td>
                                                <td>{{ $val->created_at }}</td>
                                                <td>{{ $val->nama_user }}</td>
                                                <td align="center">
                                                    <form action= "{{ route('product.destroy', $val->kode) }}" method="post">        
                                                        @csrf
                                                                       
                                                        <a href="{{ route('product.view', $val->kode) }}" class="btn btn-warning btn-sm">Ubah</a>
                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            {!! $product->links() !!}
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection

