<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Warung Madura</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }

            :root {
            --bs-primary: #0d6efd;
            --bs-primary-rgb: 13, 110, 253;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(13, 110, 253, 0.9)), url('/api/placeholder/1920/1080');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 0;
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: var(--bs-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .testimonial-card {
            border: none;
            border-radius: 15px;
        }
        
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .btn-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        </style>
    </head>
    <body>
    
        <!-- Navbar hanya muncul jika pengguna sudah login dan bukan di halaman login -->
        @if (Auth::check() && !Route::is('login'))
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container">
                    <a class="navbar-brand" href="#">Warung Madura</a>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <!-- Menu untuk pengguna terautentikasi -->
                            @if (Auth::user()->role == 'user')
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('item.homeshop') ? 'active' : '' }}" aria-current="page" href="{{ route('item.homeshop') }}">Daftar Product</a>
                                </li>
                            @elseif (Auth::user()->role == 'admin')
                                <!-- Menu khusus admin -->
                              
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('item.homeshop') ? 'active' : '' }}" aria-current="page" href="{{ route('item.homeshop') }}">Daftar Product</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('item.home') }}">Data Barang</a>
                                </li>

                            
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('pembelian') ? 'active' : '' }}" aria-current="page" href="#">Pembelian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('user.homeuser') ? 'active' : '' }}" aria-current="page" href="{{ route('user.homeuser') }}">Data Akun</a>
                                </li>
                            @elseif (Auth::user()->role == "kasir")
                                <!-- Menu khusus kasir -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Barang
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('item.home') }}">Data Barang</a></li>
                                        <li><a class="dropdown-item" href="{{ route('item.create') }}">Tambah</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('logout') }}">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
    
        <div class="container mt-5">
            @yield('content-dinamis')
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

        @stack('script')
    </body>
</html>
