<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Card Header -->
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-sign-in-alt"></i>
            Login
        </h2>
        <p class="card-description">Silakan masuk ke akun Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
                       autofocus 
                       autocomplete="username"
                       placeholder="nama@email.com"
                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
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
                       autocomplete="current-password"
                       placeholder="Masukkan password"
                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
                <input type="checkbox" 
                       name="remember" 
                       id="remember_me"
                       class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500 focus:ring-2">
                <span class="ml-2 text-sm text-gray-700">Remember me</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-red-700 font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition duration-200 ease-in-out">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Masuk
            </button>
        </div>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" 
                       class="font-semibold text-red-600 hover:text-red-700 hover:underline transition duration-200">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        @endif
    </form>

    <style>
        /* Remove default focus styles and apply custom ones */
        input:focus {
            outline: none;
        }

        /* Checkbox custom styling */
        input[type="checkbox"]:checked {
            background-color: #e74c3c;
            border-color: #e74c3c;
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