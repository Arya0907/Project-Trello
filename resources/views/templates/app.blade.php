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
            
            body {
                font-family: 'Poppins', sans-serif;
            }

            .navbar {
                background-color: white !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                padding: 0.8rem 0;
            }

            .navbar-brand {
                font-weight: 700;
                color: var(--primary-color) !important;
                font-size: 1.5rem;
            }

            .navbar-brand i {
                color: var(--primary-color);
            }

            .nav-link {
                color: #555 !important;
                font-weight: 500;
                padding: 0.5rem 1rem !important;
                border-radius: 6px;
                transition: all 0.3s ease;
                margin: 0 0.2rem;
            }

            .nav-link:hover {
                color: var(--primary-color) !important;
                background-color: rgba(255, 107, 53, 0.1);
            }

            .nav-link.active {
                color: var(--primary-color) !important;
                background-color: rgba(255, 107, 53, 0.1);
            }

            .profile-section {
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .profile-dropdown .dropdown-toggle {
                padding: 0;
                background: none;
                border: none;
            }

            .profile-img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid var(--primary-color);
            }

            .dropdown-menu {
                border: none;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                border-radius: 8px;
                padding: 0.5rem;
                min-width: 240px;
            }

            .dropdown-item {
                padding: 0.7rem 1rem;
                border-radius: 6px;
                transition: all 0.3s ease;
            }

            .dropdown-item:hover {
                background-color: rgba(255, 107, 53, 0.1);
                color: var(--primary-color);
            }

            .dropdown-item i {
                width: 20px;
            }

            .logout-btn {
                color: #dc3545 !important;
            }

            .logout-btn:hover {
                background-color: rgba(220, 53, 69, 0.1) !important;
            }

            /* Existing styles remain the same */
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
                background-color: var(--primary-color);
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
            <nav class="navbar navbar-expand-lg sticky-top">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <i class="fas fa-store-alt me-2"></i>
                        Warung Madura
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <i class="fas fa-home me-1"></i>Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('products') ? 'active' : '' }}" href="{{ route('products') }}">
                                    <i class="fas fa-boxes me-1"></i>Products
                                </a>
                            </li>

                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'kasir')
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('item.home.item') ? 'active' : '' }}" href="{{ route('item.home.item') }}">
                                        <i class="fas fa-shopping-basket me-1"></i>Daftar Product
                                    </a>
                                </li>
                            @endif


                            @if (Auth::user()->role == 'user')
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i>Cart
                                </a>
                            </li>
                            @endif

                
                            @if (Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('orders.admin') ? 'active' : '' }}" href="{{ route('orders.admin') }}">
                                        <i class="fas fa-clipboard-list me-1"></i>Orders Admin
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('user.homeuser') ? 'active' : '' }}" href="{{ route('user.homeuser') }}">
                                        <i class="fas fa-users me-1"></i>Data Akun
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->role == "kasir")
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('orders') ? 'active' : '' }}" href="{{ route('orders') }}">
                                        <i class="fas fa-shopping-cart me-1"></i>Daftar Pembelian
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <!-- Profile Section -->
                        <div class="profile-section">
                            <div class="dropdown profile-dropdown">
                                <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}&background=FF6B35&color=ffffff" 
                                     alt="Profile" 
                                     class="profile-img"
                                     data-bs-toggle="dropdown" 
                                     aria-expanded="false">
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <div class="dropdown-item">
                                            <div class="fw-bold">{{Auth::user()->name}}</div>
                                            <small class="text-muted">{{Auth::user()->role}}</small>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="fas fa-user-circle"></i> Profile
                                        </a>
                                    </li>                                    
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-cog"></i>
                                            Settings
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item logout-btn" href="{{ route('logout') }}">
                                            <i class="fas fa-sign-out-alt"></i>
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        @endif
    
        <div class="container mt-5">
            @yield('content-dinamis')
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        @stack('css')
        @stack('script')
        @stack('style')
    </body>
</html>