<x-guest-layout>
    <!-- Card Header -->
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-user-plus"></i>
            Register
        </h2>
        <p class="card-description">Buat akun baru Anda</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-5">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Lengkap
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <input id="name" 
                       type="text" 
                       name="name" 
                       value="{{ old('name') }}"
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="Masukkan nama lengkap"
                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200">
            </div>
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required 
                       autocomplete="username"
                       placeholder="nama@email.com"
                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                Password
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                Konfirmasi Password
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input id="password_confirmation" 
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       placeholder="Ulangi password"
                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200">
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-red-700 font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition duration-200 ease-in-out">
            <i class="fas fa-user-plus mr-2"></i>
            Daftar Sekarang
        </button>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" 
                   class="font-semibold text-red-600 hover:text-red-700 hover:underline transition duration-200">
                    Login di sini
                </a>
            </p>
        </div>
    </form>

    <style>
        /* Remove default focus styles and apply custom ones */
        input:focus {
            outline: none;
        }

        /* Error styling */
        .text-red-600 {
            color: #e74c3c;
        }

        /* Smooth transitions */
        input, button, a {
            transition: all 0.2s ease-in-out;
        }
    </style>
</x-guest-layout>