@extends('templates.app')

@push('style')
<style>
    /* Styling Card */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.1);
    }

    /* Styling Modal */
    .cookies-card {
        width: 100%;
        background-color: rgb(255, 250, 250);
        border-radius: 10px;
        border: 1px solid rgb(206, 206, 206);
        padding: 20px;
        gap: 15px;
        font-family: Arial, Helvetica, sans-serif;
        box-shadow: none; /* Removing shadow from modal */
    }

    .cookie-heading {
        color: rgb(34, 34, 34);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .cookie-para {
        font-size: 14px;
        font-weight: 400;
        color: rgb(51, 51, 51);
        margin-bottom: 15px;
    }

    /* Button wrapper for Card */
    .card-body .d-flex {
        display: flex;
        justify-content: flex-start; /* Buttons side by side */
        gap: 10px; /* Adding some space between buttons */
    }

    /* Card Button Styles */
    .card-body .btn {
        width: auto;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .card-body .btn-primary {
        background-color: #007bff; /* Blue color */
        color: white;
    }

    .card-body .btn-secondary {
        background-color: #ececec;
        color: rgb(34, 34, 34);
    }

    .card-body .btn-primary:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    .card-body .btn-secondary:hover {
        background-color: #ddd;
    }

    /* Button wrapper for Modal */
    .button-wrapper {
        display: flex;
        justify-content: flex-start; /* Buttons side by side */
        gap: 10px; /* Adding some space between buttons */
    }

    /* Modal Button Styles */
    .cookie-button {
        width: auto; /* Allow buttons to resize based on text */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .cookie-button.accept {
        background-color: #007bff; /* Blue color */
        color: white;
    }

    .cookie-button.reject {
        background-color: #ececec;
        color: rgb(34, 34, 34);
    }

    .cookie-button.accept:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    .cookie-button.reject:hover {
        background-color: #ddd;
    }

    /* Close Button for Modal */
    .exit-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        cursor: pointer;
    }

    .svgIconCross {
        width: 12px;
        height: 12px;
    }

</style>
@endpush

@section('content-dinamis')
<div class="container mt-5">
    <div class="row">
        @foreach($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ asset('assets/images/' . $item->image) }}" 
                     class="card-img-top" 
                     alt="Image of {{ $item->name }}" 
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->deskripsi }}</p>
                    <p class="card-text">
                        <strong>Rp{{ number_format($item->price, 2) }}</strong>
                    </p>
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#buyModal{{ $item->id }}">
                            Beli
                        </button>
                        <button class="btn btn-secondary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#cartModal{{ $item->id }}">
                            Keranjang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Buy Modal -->
            <div class="modal fade" id="buyModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content cookies-card">
                        <button class="exit-button" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" class="svgIconCross">
                                <path d="M1 1l8 8m-8 0l8-8" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </button>
                        <h3 class="cookie-heading">Konfirmasi Pembelian</h3>
                        <p class="cookie-para">Apakah Anda yakin ingin membeli {{ $item->name }}?</p>
                        <p class="cookie-para"><strong>Total: Rp{{ number_format($item->price, 2) }}</strong></p>
                        <div class="button-wrapper">
                            <form action="{{ route('orders.store.id', $item->id) }}" method="POST" class="w-100">
                                @csrf
                                <button type="button" class="cookie-button reject" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="cookie-button accept">Konfirmasi Beli</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Modal -->
            <div class="modal fade" id="cartModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content cookies-card">
                        <button class="exit-button" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" class="svgIconCross">
                                <path d="M1 1l8 8m-8 0l8-8" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </button>
                        <h3 class="cookie-heading">Tambah ke Keranjang</h3>
                        <p class="cookie-para">Tambahkan {{ $item->name }} ke keranjang Anda?</p>
                        <div class="button-wrapper">
                            <button class="cookie-button reject" data-bs-dismiss="modal">Batal</button>
                            <a href="{{ route('cart.store', $item->id) }}" class="cookie-button accept text-center">Ya, Tambahkan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('script')
<script>
    // Optional: Add additional interactivity or animations here
    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function () {
                this.classList.add('modal-show');
            });
            modal.addEventListener('hide.bs.modal', function () {
                this.classList.remove('modal-show');
            });
        });
    });
</script>
@endpush
