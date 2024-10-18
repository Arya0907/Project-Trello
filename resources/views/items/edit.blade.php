@extends('templates.app')

@section('content-dinamis')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4 fw-bold text-primary">Edit Item</h4>
                    <form action="{{ route('item.update', $item['id']) }}" method="POST">
                    @csrf
                       @method('PATCH')

                        @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li class="ml-2">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        
                        
                        <div class="mb-4">
                            <label for="name" class="form-label text-muted fw-medium">Nama Barang</label>
                            <input type="text" class="form-control form-control-lg border-0 bg-light" 
                                   name="name" id="name"  value="{{$item['name'] }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="type" class="form-label text-muted fw-medium">Jenis Barang</label>
                            <select class="form-select form-select-lg border-0 bg-light" name="type" id="type">
                                <option selected disabled hidden>Pilih jenis barang</option>
                                <option value="Minuman"  {{$item['type'] == 'Minuman' ? 'selected' : ''}}>Minuman</option>
                                <option value="Makanan" {{$item['type'] == 'Makanan' ? 'selected' : ''}}>Makanan</option>
                                <option value="Lainnya" {{$item['type'] == 'Lainnya' ? 'selected' : ''}}>Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="Harga" class="form-label text-muted fw-medium">Harga Item</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">Rp</span>
                                <input type="number" class="form-control form-control-lg border-0 bg-light" 
                                       name="price" id="price" placeholder="0"  value="{{$item['price']}}">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="stok" class="form-label text-muted fw-medium">Stock Barang</label>
                            <input type="number" class="form-control form-control-lg border-0 bg-light" 
                                   name="stok" id="stok" placeholder="Masukkan jumlah stock"   value="{{$item['stok']}}">
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label text-muted fw-medium">Deskripsi Barang</label>
                            <input type="text" class="form-control form-control-lg border-0 bg-light"
                                name="deskripsi" id="deskripsi" placeholder="Masukan deskripsi barang"
                                value="{{ old('deskripsi') }}">
                        </div>
                        
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">
                               Ubah Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border: 1px solid #0d6efd;
    }
    
    .form-control, .form-select {
        transition: all 0.3s ease;
    }
    
    .form-control:hover, .form-select:hover {
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