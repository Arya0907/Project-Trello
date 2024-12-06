

@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <h4 class="dashboard-title">Data Penjualan</h4>
            <div class="d-flex gap-3">
                <form class="d-flex" role="search" action="{{ route('orders') }}" method="GET">
                    <input class="form-control me-2" type="date" placeholder="Cari Pesanan" aria-label="Search"
                        name="search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <a href="{{route('orders.export.excel')}}" class="btn btn-primary"><i  style="color: #ffffff;">Excel</i></a>
                <a href="/" class="btn btn-primary">
                    <i class="fa-solid fa-house"></i>
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <div class="stats-card-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stats-card-info">
                            <h6>Total Pendapatan</h6>
                            <h3>Rp {{ number_format($orders->sum(function($order) {
                                return $order->total_price + ($order->total_price * 0.1);
                            }), 0, ',', '.') }}</h3>
                            <p class="stats-card-desc">Termasuk PPN 10%</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <div class="stats-card-icon bg-info">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stats-card-info">
                            <h6>Total Transaksi</h6>
                            <h3>{{ $orders->count() }}</h3>
                            <p class="stats-card-desc">Jumlah Pesanan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <div class="stats-card-icon bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-card-info">
                            <h6>Total Pelanggan</h6>
                            <h3>{{ $orders->unique('name_customer')->count() }}</h3>
                            <p class="stats-card-desc">Pelanggan Unik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card custom-table-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Pesanan</th>
                                <th>Kasir</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr class="table-row-animate">
                                    <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + ($index + 1) }}</td>
                                    <td>
                                        <div class="customer-info">
                                            <span class="customer-name">{{ $order->name_customer }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($order->items as $item)
                                            <div class="order-item">
                                                <span class="item-name">{{ $item['name_item'] }}</span>
                                                <span class="item-quantity">{{ $item['quantity'] }} pcs</span>
                                                <span class="item-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="cashier-info">
                                            <span class="cashier-name">{{ $order['user']['name']}}</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            {{ carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM Y') }}
                                        </div>
                                    </td>
                                    @php
                                        $ppn = $order->total_price * 0.1;
                                    @endphp
                                    <td>
                                        <div class="price-info">
                                            <span class="total-price">Rp {{ number_format($order->total_price + $ppn, 0, ',', '.') }}</span>
                                            <span class="ppn-info">Inc. PPN</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4CAF50;
            --info-color: #2196F3;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --shadow-sm: 0 2px 4px rgba(0,0,0,.075);
            --shadow-md: 0 4px 6px rgba(0,0,0,.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,.1);
            --border-radius: 1rem;
        }

        /* Dashboard Title */
        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
        }

        .dashboard-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card-body {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stats-card-icon {
            background: var(--primary-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stats-card-icon.bg-info {
            background: var(--info-color);
        }

        .stats-card-icon.bg-success {
            background: var(--success-color);
        }

        .stats-card-info h6 {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stats-card-info h3 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stats-card-desc {
            color: #6c757d;
            font-size: 0.75rem;
            margin: 0;
        }

        /* Table Styling */
        .custom-table-card {
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: none;
        }

        .custom-table {
            margin: 0;
        }

        .custom-table thead tr {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .custom-table thead th {
            color: white;
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
        }

        .custom-table tbody tr:hover {
            background: rgba(67, 97, 238, 0.05);
        }

        .table-row-animate {
            animation: fadeIn 0.5s ease-out;
        }

        /* Customer Info */
        .customer-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-name {
            font-weight: 600;
            color: var(--dark-color);
        }

        /* Order Item */
        .order-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding: 0.5rem 0;
        }

        .item-name {
            font-weight: 600;
            color: var(--dark-color);
        }

        .item-quantity {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .item-price {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* Price Info */
        .price-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .total-price {
            font-weight: 700;
            color: var(--primary-color);
        }

        .ppn-info {
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* Download Button */
        .btn-download {
            background: var(--info-color);
            color: white;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-download:hover {
            background: darken(var(--info-color), 10%);
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .stats-card-body {
                flex-direction: column;
                text-align: center;
            }

            .stats-card-icon {
                margin: 0 auto;
            }

            .custom-table {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush