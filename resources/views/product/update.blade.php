@extends('layouts.admin')

@section('title')
    <title>Tambah Produk</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Produk</li>
        <li class="breadcrumb-item">Produk</li>
        <li class="breadcrumb-item active">Update Produk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('product.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Update Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="name">Id Produk</label>
                                    <input type="text" name="kode" class="form-control" value="{{ $product->kode }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Produk</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->nama_barang }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="merk">Merk</label>
                                    <input type="text" name="merk" class="form-control" value="{{ $product->merk }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi/Spek</label>
                                    <textarea name="description" id="description" rows="6" ="" class="form-control">{{ $product->ket }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="merk">Satuan</label>
                                    <input type="text" name="satuan" class="form-control" value="{{ $product->satuan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Harga</label>
                                    <input type="text" name="price" class="form-control" value="{{ $product->price }}" style="text-align: right;" required>
                                </div>

                                <div class="form-group">
                                    <label for="stock">Stok</label>
                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" style="text-align: right;" required>
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <select name="category_id" class="form-control">
                                        <option value="{{ $product->category_id }}">{{ $product->kategori }}</option>
                                        @foreach ($category as $row)
                                            <option value="{{ $row->id }}" {{ old('id') == $row->id ? 'selected':'' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <br>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">U b a h</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

