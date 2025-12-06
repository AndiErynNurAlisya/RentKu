<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- TITLE is pulled from the component, e.g., <x-layouts.customer title="Beranda"> --}}
    <title>{{ $title ?? 'Customer' }} - RentKu</title>
    
    {{-- Asumsi Anda sudah mengimpor Font Awesome di app.blade.php atau di resources/css/app.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: var(--color-bg-light); }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        /* --- Navbar --- */
        .navbar { 
            background: var(--color-secondary); /* Navbar background: Dark Grey */
            color: white; 
            padding: 15px 0; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15); 
            position: sticky; 
            top: 0; 
            z-index: 1000;
        }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; font-weight: 700; display: flex; align-items: center; }
        .navbar h1 i { margin-right: 8px; color: var(--color-primary); }
        
        .navbar nav a { 
            color: white; 
            text-decoration: none; 
            margin-left: 20px; 
            padding: 8px 15px; 
            border-radius: 5px; 
            transition: background 0.3s, color 0.3s; 
            font-size: 15px;
            font-weight: 500;
            display: inline-flex; /* Agar ikon dan teks sejajar */
            align-items: center;
        }
        .navbar nav a i {
            margin-right: 6px;
        }
        .navbar nav a:hover, .navbar nav a.active { 
            background: rgba(255,255,255,0.2); 
            color: var(--color-primary); /* Use primary color on active/hover for contrast */
        }
        .navbar nav button {
            background: var(--color-primary); 
            border: 1px solid var(--color-primary);
            color: white; 
            cursor: pointer; 
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
            display: inline-flex;
            align-items: center;
        }
        .navbar nav button i {
            margin-right: 6px;
        }
        .navbar nav button:hover {
            background: #c0392b; /* Darker red */
        }
        
        /* --- Alert --- */
        .alert { 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 0.5rem; 
            font-size: 15px;
            display: flex;
            align-items: center;
        }
        .alert-success { 
            background: #f4d0d0; /* Light red background */
            color: var(--color-secondary); /* Dark text */
            border: 1px solid var(--color-primary); 
            border-left: 6px solid var(--color-primary);
        }
        .alert-error { 
            background: #f4d0d0; 
            color: var(--color-secondary); 
            border: 1px solid var(--color-primary);
            border-left: 6px solid var(--color-primary);
        }
        .alert-error ul {
            list-style-type: disc;
            margin-top: 5px;
            padding-left: 20px;
        }
        .alert-error li {
            font-size: 14px;
        }
        
        /* --- Card & Form (Basic Styles) --- */
        .card { 
            background: white; 
            border-radius: 8px; 
            padding: 20px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            margin-bottom: 20px; 
        }
        .form-control { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #d1d5db; 
            border-radius: 5px; 
            font-size: 14px; 
            color: var(--color-secondary);
        }
        .form-control:focus { 
            outline: none; 
            border-color: var(--color-primary); 
            box-shadow: 0 0 0 1px var(--color-primary);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="container">
            <h1><i class="fas fa-car-side"></i> RentKu</h1>
            <nav>
                <a href="{{ route('customer.home') }}" class="{{ request()->routeIs('customer.home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="{{ route('customer.rentals.index') }}" class="{{ request()->routeIs('customer.rentals.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Riwayat Sewa
                </a>
                <a href="{{ route('customer.profile') }}" class="{{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" title="Logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Content -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan input:
                <ul style="margin-left: 25px; margin-top: 8px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </div>
</body>
</html>