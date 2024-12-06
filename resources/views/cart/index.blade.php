
@extends('templates.app')

@section('content-dinamis')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .cart-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        }
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background: #0d6efd;
            border: none;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background: #0b5ed7;
        }
        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-light">
    @if(Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif 
    <div class="cart-header text-white py-4 mb-4">
        <div class="container">
            <h1 class="display-6 fw-bold"><i class="bi bi-cart3"></i> Your Shopping Cart</h1>
        </div>
    </div>

    <div class="container mb-5">
        @if($carts->count() > 0)
            <div class="row">
                <div class="col-lg-8">
                    @foreach($carts as $cart)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <img src="{{ $cart->item->image ? asset('assets/images/' . $cart->item->image) : 'https://via.placeholder.com/120' }}" 
                                            class="product-image rounded" 
                                            alt="{{ $cart->item->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title text-primary mb-2">{{ $cart->item->name }}</h5>
                                        <p class="card-text text-muted mb-2">Price: Rp{{ number_format($cart->item->price, 2) }}</p>
                                        <p class="card-text">Quantity: {{ $cart->quantity }}</p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <h5 class="text-primary mb-3">Rp{{ number_format($cart->item->price * $cart->quantity, 2) }}</h5>
                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal</span>
                                <span class="fw-bold">Rp{{ number_format($carts->sum(function($cart) { return $cart->item->price * $cart->quantity; }), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping</span>
                                <span class="text-success">Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-primary">Rp{{ number_format($carts->sum(function($cart) { return $cart->item->price * $cart->quantity; }), 2) }}</span>
                            </div>
                            <form action="{{route('order.checkout')}} " method="POST">
                                @csrf
                            <!-- Tombol Checkout -->
                            <button type="submit" id="checkoutButton" class="btn btn-primary w-100">
                                Proceed to Checkout <i class="bi bi-arrow-right"></i>
                            </button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x display-1 text-muted"></i>
                <h3 class="mt-4">Your cart is empty</h3>
                <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('products') }}" class="btn btn-primary mt-3">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
</body>
</html>

@endsection

