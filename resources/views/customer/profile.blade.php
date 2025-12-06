<x-layouts.customer title="Profil">

    {{-- CUSTOM STYLES --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
            --color-dark-text: #111827;
            --color-info-bg: #f4d0d0; /* Very light Red for accents */
            --color-success-status: var(--color-secondary);
        }

        /* --- Header Section --- */
        .header-profile {
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%) !important;
            border-radius: 16px; 
            padding: 40px; 
            margin-bottom: 32px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            color: white;
            display: flex;
            align-items: center;
        }
        .profile-icon-wrapper {
            width: 80px; 
            height: 80px; 
            background: rgba(255,255,255,0.2); 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 36px; 
            margin-right: 24px; 
            border: 3px solid rgba(255,255,255,0.3);
        }
        .profile-icon-wrapper i { color: white; }

        /* --- Main Content Cards --- */
        .main-card {
            background: white; 
            border-radius: 16px; 
            padding: 32px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .main-card h2 { 
            font-size: 24px; 
            font-weight: 700; 
            color: var(--color-dark-text); 
            margin-bottom: 24px; 
            padding-bottom: 16px; 
            border-bottom: 2px solid var(--color-bg-light); 
        }

        /* --- Form Controls --- */
        .form-control-styled {
            width: 100%; 
            padding: 12px 16px; 
            border: 1.5px solid var(--color-bg-light); 
            border-radius: 8px; 
            font-size: 15px; 
            transition: all 0.2s;
            color: var(--color-secondary);
        }
        .form-control-disabled {
            background: var(--color-bg-light); 
            cursor: not-allowed; 
            color: var(--color-text-light);
        }
        .form-control-styled:focus {
            border-color: var(--color-primary) !important; 
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1) !important;
            outline: none;
        }
        
        /* --- Sidebar --- */
        .sidebar-info-card {
            background: white; 
            border-radius: 16px; 
            padding: 28px; 
            margin-bottom: 20px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .sidebar-stats-card {
            background: var(--color-info-bg); 
            border-radius: 16px; 
            padding: 28px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid var(--color-primary);
        }
        .sidebar-stats-card .stat-value {
            font-size: 32px; 
            font-weight: 700; 
            color: var(--color-primary); 
        }
        .status-badge {
            display: inline-block; 
            padding: 6px 14px; 
            background: var(--color-secondary); 
            color: white; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 600;
        }

        /* --- Primary Button --- */
        .btn-action-primary {
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%) !important; 
            color: white;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-action-primary:hover {
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
        }
    </style>

    <!-- Header Section -->
    <div class="header-profile">
        <div class="profile-icon-wrapper">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 8px;">{{ $user->name }}</h1>
            <p style="opacity: 0.9; font-size: 16px; margin: 0;">{{ $user->email }}</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <!-- Main Form -->
        <div class="main-card">
            <h2 style="color: var(--color-secondary);">
                <i class="fas fa-edit" style="margin-right: 8px; color: var(--color-primary);"></i> Edit Profil
            </h2>

            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                        Nama Lengkap <span style="color: var(--color-primary);">*</span>
                    </label>
                    <input type="text" name="name" class="form-control-styled" value="{{ old('name', $user->name) }}" required>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                        Email <span style="color: var(--color-primary);">*</span>
                    </label>
                    <input type="email" class="form-control-styled form-control-disabled" value="{{ $user->email }}" disabled>
                    <small style="color: var(--color-text-light); font-size: 13px; display: block; margin-top: 6px;">
                        <i class="fas fa-info-circle"></i> Email tidak dapat diubah untuk keamanan akun
                    </small>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                        Nomor Telepon/WhatsApp <span style="color: var(--color-primary);">*</span>
                    </label>
                    <input type="text" name="phone" class="form-control-styled" value="{{ old('phone', $user->phone) }}" required placeholder="081234567890">
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                        Alamat Lengkap <span style="color: var(--color-primary);">*</span>
                    </label>
                    <textarea name="address" class="form-control-styled" required rows="3">{{ old('address', $user->address) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                            Nomor KTP/NIK <span style="color: var(--color-primary);">*</span>
                        </label>
                        <input type="text" name="identity_number" class="form-control-styled" value="{{ old('identity_number', $user->identity_number) }}" required placeholder="3173xxxxxxxxxx">
                    </div>

                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                            Nomor SIM <span style="color: var(--color-primary);">*</span>
                        </label>
                        <input type="text" name="driver_license" class="form-control-styled" value="{{ old('driver_license', $user->driver_license) }}" required placeholder="Nomor SIM Anda">
                    </div>
                </div>

                <button type="submit" class="btn-action-primary" 
                        style="width: 100%; padding: 14px; font-size: 16px; font-weight: 600; border-radius: 8px;">
                    <i class="fas fa-save" style="margin-right: 6px;"></i> Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div>
            <!-- Account Info Card -->
            <div class="sidebar-info-card">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--color-secondary); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid var(--color-bg-light);">
                    <i class="fas fa-info-circle" style="margin-right: 6px; color: var(--color-primary);"></i> Informasi Akun
                </h3>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 13px; color: var(--color-text-light); margin-bottom: 4px;">Status Akun</div>
                    <div class="status-badge">
                        <i class="fas fa-check"></i> Aktif
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <div style="font-size: 13px; color: var(--color-text-light); margin-bottom: 4px;">Terdaftar Sejak</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--color-dark-text);">
                        {{ $user->created_at->format('d F Y') }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 13px; color: var(--color-text-light); margin-bottom: 4px;">Total Transaksi</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--color-dark-text);">
                        {{ $user->rentals->count() }} transaksi
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="sidebar-stats-card">
                <div style="text-align: center;">
                    <div class="stat-icon-wrapper" style="font-size: 48px; margin-bottom: 12px; color: var(--color-secondary);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value">
                        {{ $user->rentals->where('status', 'completed')->count() }}
                    </div>
                    <div style="font-size: 14px; color: var(--color-text-light);">Sewa Selesai</div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.customer>