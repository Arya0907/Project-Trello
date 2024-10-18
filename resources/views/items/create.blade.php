@extends('templates.app')

@section('content-dinamis')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 fw-bold text-primary">Tambah Item Baru</h4>
                        <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (Session::get('success'))
                                <div class="alert alert-success">{{ Session::get('success') }}</div>
                            @endif

                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li class="ml-2">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="mb-4">
                                <label for="name" class="form-label text-muted fw-medium">Nama Barang</label>
                                <input type="text" class="form-control form-control-lg border-0 bg-light" name="name"
                                    id="name" placeholder="Masukkan nama barang" value="{{ old('name') }}">
                            </div>

                            <div class="mb-4">
                                <label for="type" class="form-label text-muted fw-medium">Jenis Barang</label>
                                <select class="form-select form-select-lg border-0 bg-light" name="type" id="type">
                                    <option selected disabled hidden>Pilih jenis barang</option>
                                    <option value="Minuman" {{ old('type') == 'Minuman' ? 'selected' : '' }}>Minuman
                                    </option>
                                    <option value="Makanan" {{ old('type') == 'Makanan' ? 'selected' : '' }}>Makanan
                                    </option>
                                    <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="form-label text-muted fw-medium">Harga Item</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light">Rp</span>
                                    <input type="number" class="form-control form-control-lg border-0 bg-light"
                                        name="price" id="price" placeholder="0" value="{{ old('price') }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="stok" class="form-label text-muted fw-medium">Stock Barang</label>
                                <input type="number" class="form-control form-control-lg border-0 bg-light" name="stok"
                                    id="stok" placeholder="Masukkan jumlah stock" value="{{ old('stok') }}">
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label text-muted fw-medium">Deskripsi Barang</label>
                                <input type="text" class="form-control form-control-lg border-0 bg-light"
                                    name="deskripsi" id="deskripsi" placeholder="Masukan deskripsi barang"
                                    value="{{ old('deskripsi') }}">
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label text-muted fw-medium">Upload Image</label>
                                <input type="file" class="form-control form-control-lg border-0 bg-light" name="image"
                                    id="image" accept="image/*"> <!-- Hanya menerima file gambar -->
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Tambah Data
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border: 1px solid #0d6efd;
        }

        .form-control,
        .form-select {
            transition: all 0.3s ease;
        }

        .form-control:hover,
        .form-select:hover {
            background-color: #e9ecef !important;
        }

        .btn-primary {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
    </style>
@endsection
