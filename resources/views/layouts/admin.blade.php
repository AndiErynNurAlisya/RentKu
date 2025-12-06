<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} - RentKu</title>
    
    {{-- Asumsi Font Awesome diimpor --}}
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
        body { font-family: 'Inter', sans-serif; background: var(--color-bg-light); }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }

        /* --- NAVBAR --- */
        .navbar { 
            background: var(--color-secondary); 
            color: white; 
            padding: 15px 0; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15); 
            font-weight: 700;
            position: sticky; 
            top: 0; 
            z-index: 1000;
        }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; display: flex; align-items: center; }
        .navbar h1 i { margin-right: 8px; color: var(--color-primary); } /* Icon styling */
        
        .navbar nav a { 
            color: white; 
            text-decoration: none; 
            margin-left: 20px; 
            padding: 8px 15px; 
            border-radius: 5px; 
            transition: background 0.3s; 
            font-size: 15px;
            font-weight: 500;
        }

        /* Hover dan active → warna merah */
        .navbar nav a:hover, 
        .navbar nav a.active { 
            background: var(--color-primary); 
            color: white; /* Pastikan teks tetap putih di atas aksen merah */
        }
        .navbar nav button {
            background: none; 
            border: none; 
            color: white; 
            cursor: pointer; 
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
            font-size: 15px;
            font-weight: 500;
        }
        .navbar nav button:hover {
            background: var(--color-primary); 
        }

        /* --- ALERT --- */
        .alert { 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 0.5rem; 
            font-size: 15px;
            border-left: 6px solid;
            display: flex;
            align-items: center;
        }
        .alert i { margin-right: 8px; }
        .alert-success { 
            background: #f4d0d0; /* Light red */
            color: var(--color-secondary); 
            border-color: var(--color-secondary); 
        }
        .alert-error { 
            background: #f4d0d0; 
            color: var(--color-secondary); 
            border-color: var(--color-primary);
        }

        /* --- CARD --- */
        .card { 
            background: white; 
            border-radius: 8px; 
            padding: 20px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            margin-bottom: 20px; 
        }
        .card-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
            padding-bottom: 15px; 
            border-bottom: 2px solid var(--color-bg-light); 
        }
        .card-header h2 { font-size: 20px; color: var(--color-secondary); }

        /* --- BUTTONS --- */
        .btn { 
            display: inline-block; 
            padding: 10px 20px; 
            border: 1px solid transparent; 
            border-radius: 5px; 
            cursor: pointer; 
            text-decoration: none; 
            font-size: 14px; 
            transition: all 0.3s; 
            font-weight: 600;
        }
        .btn-primary { background: var(--color-primary); color: white; }
        .btn-primary:hover { background: #c0392b; }
        
        /* Secondary button for admin (Back/Cancel) */
        .btn-secondary { background: var(--color-bg-light); color: var(--color-secondary); border-color: var(--color-bg-light); }
        .btn-secondary:hover { background: #d8dbe0; }

        /* Success/Warning/Danger buttons use defined colors for consistency */
        .btn-success { background: var(--color-secondary); color: white; border-color: var(--color-secondary); }
        .btn-success:hover { background: #34495e; }
        .btn-warning { background: var(--color-primary); color: white; border-color: var(--color-primary); }
        .btn-warning:hover { background: #c0392b; }
        .btn-danger { background: var(--color-primary); color: white; border-color: var(--color-primary); }
        .btn-danger:hover { background: #c0392b; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }

        /* --- FORM & TABLE (Minimal base styling for consistency) --- */
        table th { 
            background: #f9fafb; 
            padding: 12px; 
            text-align: left; 
            font-weight: 600; 
            color: var(--color-secondary); 
            border-bottom: 2px solid var(--color-bg-light); 
        }
        table td { padding: 12px; border-bottom: 1px solid var(--color-bg-light); }
        .form-control { 
            border: 1px solid #d1d5db; 
            padding: 10px; 
            border-radius: 5px; 
            font-size: 14px; 
            color: var(--color-secondary);
        }
        .form-control:focus { outline: none; border-color: var(--color-primary); box-shadow: 0 0 0 1px var(--color-primary); }

        /* --- BADGE (Keeping defined colors, adjusted background/text contrast) --- */
        .badge { 
            display: inline-block; 
            padding: 4px 12px; 
            border-radius: 12px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        /* Adjusted for better contrast on limited palette */
        .badge-success { background: var(--color-secondary); color: white; }
        .badge-warning { background: #f4d0d0; color: var(--color-secondary); border: 1px solid var(--color-secondary); }
        .badge-danger { background: var(--color-primary); color: white; }
        .badge-info { background: var(--color-bg-light); color: var(--color-secondary); border: 1px solid var(--color-secondary); }

    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="container">
            <h1><i class="fas fa-user-shield"></i> RentKu Admin</h1>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home" style="margin-right: 4px;"></i> Dashboard
                </a>
                <a href="{{ route('admin.vehicles.index') }}" class="{{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                    <i class="fas fa-car" style="margin-right: 4px;"></i> Kendaraan
                </a>
                <a href="{{ route('admin.rentals.index') }}" class="{{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt" style="margin-right: 4px;"></i> Transaksi Sewa
                </a>
                <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fas fa-users" style="margin-right: 4px;"></i> Pelanggan
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

        @yield('content')
    </div>
</body>
</html>