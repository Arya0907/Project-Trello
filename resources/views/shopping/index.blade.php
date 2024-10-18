@extends('templates.app')

@section('content-dinamis')
<div class="container mt-5">
    <div class="row">
        @foreach($items as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100"> 
                    <img src="{{ asset('assets/images/' . $item->image) }}" class="card-img-top" alt="Image of {{ $item->name }}" style="height: 200px; object-fit: cover;"> <!-- Mengatur tinggi dan style untuk gambar -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ $item->deskripsi }}</p>
                        <p class="card-text"><strong>Rp{{ number_format($item->price, 2) }}</strong></p>
                        <a href="#" class="btn btn-primary">Beli</a>
                        <a href="#" class="btn btn-secondary">Tambahkan Ke keranjang</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
