@extends('templates.app')

@section('content-dinamis')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Purchase History Column -->
        <div class="bg-white rounded-2xl shadow-lg p-6 transform transition-all hover:scale-[1.02]">
            <h1 class="text-3xl font-bold mb-6 text-blue-600 flex items-center">
                📦 Riwayat Pembelian <span class="ml-2 text-sm text-gray-500">({{ count(json_decode(Auth::user()->orders) ?? []) }})</span>
            </h1>
            
            <div class="space-y-4 max-h-[500px] overflow-y-auto purchase-history">
                @php
                    $orders = json_decode(Auth::user()->orders);
                @endphp
                
                @forelse ($orders as $index => $order)
                    <div class="purchase-item bg-gray-50 p-4 rounded-lg hover:bg-blue-50 transition-colors group">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-blue-500 font-semibold">#{{ $index + 1 }}</span>
                                    <div class="space-x-1">
                                        @foreach ($order->items as $item)
                                            <span class="text-sm text-gray-700">
                                                {{ $item->name_item }} ({{ $item->quantity }} 🛍️)
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }} 📅
                                </span>
                            </div>
                            <span class="text-green-600 font-bold">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        🛒 Tidak ada riwayat pembelian
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Profile Column -->
        <div class="profile-card bg-gradient-to-br from-blue-100 to-white rounded-2xl overflow-hidden shadow-2xl transform transition-all hover:scale-[1.01]">
            <div class="relative">
                <div class="h-32 bg-gradient-to-r from-blue-500 to-teal-400 absolute w-full top-0 left-0 opacity-80"></div>
                <div class="relative z-10 flex flex-col items-center pt-16 pb-8 px-6">
                    <img 
                        src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=FF6B35&color=ffffff" 
                        alt="Profile" 
                        class="w-32 h-32 rounded-full border-4 border-white shadow-lg mb-4 hover:rotate-6 transition-transform"
                    >
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        {{ Auth::user()->name }} 👤
                    </h2>
                    <p class="text-sm text-gray-500 mb-6">
                        Not Yet 🌟
                    </p>
                    
                    <div class="flex space-x-4">
                        <button 
                            class="btn-edit-profile px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors flex items-center"
                            data-bs-toggle="modal" 
                            data-bs-target="#editProfileModal"
                        >
                            ✏️ Edit Profil
                        </button>
                        <button class="btn-logout px-6 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors flex items-center">
                            🚪 Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl bg-gradient-to-br from-blue-50 to-white shadow-2xl border-none">
            <div class="modal-header border-0 p-6">
                <h2 class="modal-title text-3xl font-bold text-center text-blue-600 w-full" id="editProfileModalLabel">
                    ✏️ Edit Profil
                </h2>
                <button type="button" class="btn-close absolute top-4 right-4 text-gray-500 hover:text-red-500 transition-colors" data-bs-dismiss="modal" aria-label="Close">
                    ❌
                </button>
            </div>
            <div class="modal-body px-6 pb-6">
              <form action="{{ route('user.update.profile') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Nama Field -->
                <div>
                    <label for="name" class="block text-blue-700 font-semibold mb-2">
                        👤 Nama
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name"
                        value="{{ Auth::user()->name }}"
                        class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300" 
                        placeholder="Masukkan nama Anda"
                        required
                    >
                </div>
  
                <!-- Password Baru Field -->
                <div>
                    <label for="password" class="block text-blue-700 font-semibold mb-2">
                        🔐 Password Baru
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300" 
                        placeholder="Masukkan password baru"
                    >
                </div>
  
                <!-- Konfirmasi Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-blue-700 font-semibold mb-2">
                        🔒 Konfirmasi Password
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300" 
                        placeholder="Konfirmasi password baru"
                    >
                </div>
  
                <!-- Update Button -->
                <button 
                    type="submit" 
                    class="w-full text-white font-bold py-3 rounded-lg bg-gradient-to-r from-blue-500 to-teal-400 hover:from-blue-600 hover:to-teal-500 transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center space-x-2"
                >
                    <span>🚀</span>
                    <span>Update Profil</span>
                </button>
            </form>
            </div>
        </div>
    </div>
  </div>

<!-- Edit Profile Modal (Existing modal code remains the same) -->
<!-- ... (previous modal code) ... -->
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
@endpush

@push('style')
<style>

@keyframes modalSlideIn {
        from { 
            opacity: 0; 
            transform: translateY(30px) scale(0.9);
        }
        to { 
            opacity: 1; 
            transform: translateY(0) scale(1);
        }
    }

    #editProfileModal .modal-content {
        animation: modalSlideIn 0.5s ease-out;
    }

    /* Keyframe Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .animate-fade-in {
        animation: fadeIn 1s ease-out;
    }

    .purchase-item {
        animation: fadeIn 0.5s ease-out;
        transition: all 0.3s ease;
    }

    .purchase-item:hover {
        box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        animation: pulse 1s infinite;
    }

    .purchase-history {
        scrollbar-width: thin;
        scrollbar-color: #60a5fa #bae6fd;
    }

    .purchase-history::-webkit-scrollbar {
        width: 8px;
    }

    .purchase-history::-webkit-scrollbar-track {
        background: #bae6fd;
    }

    .purchase-history::-webkit-scrollbar-thumb {
        background-color: #60a5fa;
        border-radius: 20px;
    }

    /* Pulsing effect for buttons */
    .btn-edit-profile:hover, .btn-logout:hover {
        animation: pulse 1s infinite;
    }
</style>
@endpush

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#editProfileModal form');
        const passwordInput = form.querySelector('#password');
        const confirmPasswordInput = form.querySelector('#password_confirmation');

        form.addEventListener('submit', function(e) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Konfirmasi password tidak cocok! 🚫'
                });
                confirmPasswordInput.focus();
            }
        });
    });
</script>
@endpush