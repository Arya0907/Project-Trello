@extends('templates.app')

@section('content-dinamis')
<section class="hero-section" id="home">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">Warung Madura Modern</h1>
        <p class="lead mb-4">Nikmati kelezatan autentik Madura dengan sentuhan modern</p>
        <a href="{{route('item.homeshop')}}" class="btn btn-light btn-lg px-5 py-3">Lihat Menu</a>
    </div>
</section>

<!-- About Section -->
<section class="py-5" id="tentang">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="display-6 fw-bold mb-4">25 Tahun Menghadirkan Cita Rasa Madura</h2>
                <p class="lead text-muted mb-4">Perjalanan kami dimulai dari sebuah warung kecil, kini menjadi destinasi kuliner modern dengan tetap mempertahankan keaslian resep leluhur.</p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-primary me-2"></i>
                            <span>100% Bumbu Alami</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-primary me-2"></i>
                            <span>Chef Berpengalaman</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-primary me-2"></i>
                            <span>Suasana Modern</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-primary me-2"></i>
                            <span>Bahan Berkualitas</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="/api/placeholder/600/400" class="img-fluid rounded-3 shadow" alt="Suasana Warung">
                    <div class="position-absolute bottom-0 end-0 bg-primary text-white p-4 rounded-3 mb-n4 me-n4">
                        <h3 class="h2 mb-0">25+</h3>
                        <p class="mb-0">Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Preview Section -->
<!-- Menu Preview Section -->
<section class="bg-light py-5" id="menu">
    <div class="container py-5">
        <h2 class="text-center display-6 fw-bold mb-5">Menu Favorit</h2>
        <div class="row g-4">
            @foreach($featuredItems as $item)
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('assets/images/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $item->name }}</h5>
                            <p class="card-text text-muted">{{ $item->deskripsi }}</p>
                            <h6 class="fw-bold text-primary mt-auto">Rp {{ number_format($item->price, 0, ',', '.') }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Testimonial Section -->
<section class="py-5" id="testimoni">
    <div class="container py-5">
        <h2 class="text-center display-6 fw-bold mb-5">Apa Kata Mereka</h2>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card testimonial-card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <img src="/api/placeholder/80/80" class="testimonial-img mb-3" alt="Customer">
                        <h5 class="card-title">Ahmad Satriani</h5>
                        <p class="text-muted mb-3">Food Blogger</p>
                        <p class="card-text">"Sate Madura terenak yang pernah saya coba. Bumbu kacangnya khas dan dagingnya empuk sempurna!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Repeat for other testimonials -->
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="bg-light py-5" id="kontak">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="display-6 fw-bold mb-4">Hubungi Kami</h2>
                <form>
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg" placeholder="Nama Lengkap">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-lg" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control form-control-lg" rows="4" placeholder="Pesan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Kirim Pesan</button>
                </form>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Informasi Kontak</h5>
                        <div class="d-flex mb-3">
                            <div class="feature-icon me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Alamat</h6>
                                <p class="text-muted">Jl. Madura No. 123, Surabaya</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="feature-icon me-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Telepon</h6>
                                <p class="text-muted">(031) 555-0123</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="feature-icon me-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Jam Buka</h6>
                                <p class="text-muted">Setiap hari: 10:00 - 22:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Action Button -->
<a href="#" class="btn btn-primary btn-lg rounded-circle btn-floating shadow">
    <i class="fas fa-arrow-up"></i>
</a>

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
@endpush

@endsection