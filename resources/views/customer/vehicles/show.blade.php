<x-layouts.customer title="Detail Kendaraan">

    {{-- CUSTOM STYLES (inherits from layouts.customer) --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
            --color-dark-text: #111827;
            --color-info-bg: #f4d0d0; /* Very light Red for accents */
            --color-success-status: var(--color-secondary);
            --color-danger-status: var(--color-primary);
        }

        /* --- Alert Messages (Customized for consistency) --- */
        .alert-custom {
            padding: 16px 20px; 
            margin-bottom: 24px; 
            border-radius: 0.5rem; 
            border-left: 4px solid; 
            display: flex; 
            align-items: center;
        }
        .alert-custom i { margin-right: 12px; font-size: 20px; }
        .alert-error { 
            background: var(--color-info-bg); 
            color: var(--color-secondary); 
            border-color: var(--color-primary); 
        }
        .alert-success { 
            background: var(--color-info-bg); 
            color: var(--color-secondary); 
            border-color: var(--color-secondary); 
        }

        /* --- Back Button --- */
        .btn-back-style {
            display: inline-flex; 
            align-items: center; 
            padding: 10px 20px; 
            background: white; 
            border: 1.5px solid var(--color-bg-light); 
            border-radius: 8px; 
            color: var(--color-secondary); 
            text-decoration: none; 
            font-weight: 600; 
            transition: all 0.2s;
        }
        .btn-back-style:hover {
            border-color: var(--color-secondary); 
            color: var(--color-secondary);
            background: var(--color-bg-light);
        }

        /* --- Main Content --- */
        .main-card {
            background: white; 
            border-radius: 16px; 
            padding: 40px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        /* Image Section */
        .image-container {
             border-radius: 12px; 
             overflow: hidden; 
             background: var(--color-bg-light); 
             box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .image-placeholder-icon { 
            font-size: 120px; 
            opacity: 0.5;
            color: var(--color-secondary);
        }
        
        /* Category Badge */
        .category-badge-img {
            position: absolute; 
            top: 20px; 
            left: 20px; 
            background: rgba(255,255,255,0.95); 
            padding: 8px 16px; 
            border-radius: 20px; 
            font-size: 14px; 
            font-weight: 600; 
            color: var(--color-secondary); 
            backdrop-filter: blur(8px); 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid var(--color-bg-light);
            display: inline-flex;
            align-items: center;
        }
        .category-badge-img i { margin-right: 6px; }

        /* Vehicle Specs Box */
        .specs-box {
            padding: 24px; 
            background: var(--color-bg-light); 
            border-radius: 12px;
        }
        .specs-status-available { 
            padding: 4px 12px; 
            background: var(--color-secondary); 
            color: white; 
            border-radius: 12px; 
            font-size: 13px; 
            font-weight: 600;
        }
        .specs-status-unavailable { 
            padding: 4px 12px; 
            background: var(--color-primary); 
            color: white; 
            border-radius: 12px; 
            font-size: 13px; 
            font-weight: 600;
        }

        /* Price Card */
        .price-card {
            background: var(--color-info-bg); 
            padding: 28px; 
            border-radius: 12px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid var(--color-primary);
        }
        .price-value {
            font-size: 42px; 
            font-weight: 700; 
            color: var(--color-primary); 
            line-height: 1;
        }
        .price-per-day {
            font-size: 18px; 
            font-weight: 400; 
            color: var(--color-text-light);
        }

        /* Features/Benefits */
        .features-box {
            background: var(--color-bg-light); 
            padding: 24px; 
            border-radius: 12px;
        }
        .feature-item {
            display: flex; 
            align-items: center;
        }
        .feature-icon {
            color: var(--color-secondary); /* Use Secondary for checkmark */
            margin-right: 8px; 
            font-size: 18px;
        }

        /* Action Buttons */
        .btn-action-primary {
            display: block; 
            padding: 16px; 
            text-align: center; 
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%); 
            color: white; 
            border-radius: 10px; 
            font-weight: 700; 
            font-size: 18px; 
            text-decoration: none; 
            box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3); 
            transition: all 0.3s;
        }
        .btn-action-primary:hover {
            transform: translateY(-2px); 
            box-shadow: 0 6px 20px rgba(44, 62, 80, 0.4);
        }
        .btn-action-secondary {
            display: block; 
            padding: 16px; 
            text-align: center; 
            background: white; 
            color: var(--color-secondary); 
            border: 2px solid var(--color-bg-light); 
            border-radius: 10px; 
            font-weight: 600; 
            font-size: 16px; 
            text-decoration: none; 
            transition: all 0.2s;
        }
        .btn-action-secondary:hover {
            border-color: var(--color-primary); 
            color: var(--color-primary);
        }
        
        /* Notice Box */
        .notice-box {
            padding: 16px; 
            background: var(--color-info-bg); 
            border-left: 4px solid var(--color-primary); 
            border-radius: 8px;
        }
        .notice-box i { color: var(--color-secondary); }
        .notice-box .notice-title { color: var(--color-secondary); }
        .notice-box .notice-text { color: var(--color-text-light); }
    </style>
    
    {{-- Display Alerts --}}
    @if (session('error'))
        <div class="alert-custom alert-error">
            <i class="fas fa-times-circle"></i>
            <span style="font-weight: 500;">{{ session('error') }}</span>
        </div>
    @endif
    @if (session('success'))
        <div class="alert-custom alert-success">
            <i class="fas fa-check-circle"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Back Button -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('customer.home') }}" class="btn-back-style">
            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="main-card">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px;">
            
            <!-- Left Column: Image & Specs -->
            <div>
                <!-- Image Section -->
                <div class="image-container">
                    @if($vehicle->image)
                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->brand }}" 
                             style="width: 100%; height: 400px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 400px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-{{ $vehicle->category == 'motor' ? 'motorcycle' : 'car' }} image-placeholder-icon"></i>
                        </div>
                    @endif
                    
                    <!-- Category Badge -->
                    <div class="category-badge-img">
                        <i class="fas fa-{{ $vehicle->category == 'motor' ? 'motorcycle' : 'car' }}"></i>
                        {{ $vehicle->category == 'motor' ? 'Motor' : 'Mobil' }}
                    </div>
                </div>

                <!-- Vehicle Specs -->
                <div style="margin-top: 24px;" class="specs-box">
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--color-secondary); margin-bottom: 16px;">
                        <i class="fas fa-clipboard-list" style="margin-right: 6px;"></i> Spesifikasi Kendaraan
                    </h3>
                    <div style="display: grid; gap: 12px;">
                        <div class="detail-row" style="border-bottom: 1px solid var(--color-bg-light);">
                            <span style="color: var(--color-text-light); font-size: 14px;">Plat Nomor</span>
                            <span style="font-weight: 600; color: var(--color-secondary); font-size: 14px;">{{ $vehicle->plate_number }}</span>
                        </div>
                        <div class="detail-row" style="border-bottom: 1px solid var(--color-bg-light);">
                            <span style="color: var(--color-text-light); font-size: 14px;">Kategori</span>
                            <span style="font-weight: 600; color: var(--color-secondary); font-size: 14px;">{{ $vehicle->category == 'motor' ? 'Motor' : 'Mobil' }}</span>
                        </div>
                        <div class="detail-row" style="border-bottom: none;">
                            <span style="color: var(--color-text-light); font-size: 14px;">Status Ketersediaan</span>
                            <span>
                                @if($vehicle->status == 'tersedia')
                                    <span class="specs-status-available">
                                        <i class="fas fa-check-circle" style="margin-right: 4px;"></i> Tersedia
                                    </span>
                                @else
                                    <span class="specs-status-unavailable">
                                        <i class="fas fa-times-circle" style="margin-right: 4px;"></i> Tidak Tersedia
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details & Action -->
            <div>
                <!-- Title & Plate -->
                <div style="margin-bottom: 24px;">
                    <h1 style="font-size: 36px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 12px; line-height: 1.2;">
                        {{ $vehicle->brand }} {{ $vehicle->type }}
                    </h1>
                    <div style="display: flex; align-items: center; color: var(--color-text-light); font-size: 16px;">
                        <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>
                        {{ $vehicle->plate_number }}
                    </div>
                </div>

                <!-- Price Card -->
                <div class="price-card">
                    <div style="font-size: 14px; color: var(--color-secondary); margin-bottom: 8px; font-weight: 500;">
                        Harga Sewa Per Hari
                    </div>
                    <div class="price-value">
                        Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                        <span class="price-per-day">/hari</span>
                    </div>
                </div>

                <!-- Description -->
                @if($vehicle->description)
                <div style="margin-bottom: 28px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 12px;">
                        <i class="fas fa-scroll" style="margin-right: 6px;"></i> Deskripsi
                    </h3>
                    <p style="color: var(--color-secondary); font-size: 15px; line-height: 1.7;">
                        {{ $vehicle->description }}
                    </p>
                </div>
                @endif

                <!-- Features/Benefits -->
                <div class="features-box" style="margin-bottom: 28px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--color-secondary); margin-bottom: 16px;">
                        <i class="fas fa-star" style="margin-right: 6px;"></i> Keuntungan Menyewa
                    </h3>
                    <div style="display: grid; gap: 12px;">
                        <div class="feature-item">
                            <i class="fas fa-check feature-icon"></i>
                            <span style="color: var(--color-secondary); font-size: 14px;">Kendaraan terawat dan bersih</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check feature-icon"></i>
                            <span style="color: var(--color-secondary); font-size: 14px;">Proses booking mudah dan cepat</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check feature-icon"></i>
                            <span style="color: var(--color-secondary); font-size: 14px;">Harga transparan tanpa biaya tersembunyi</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check feature-icon"></i>
                            <span style="color: var(--color-secondary); font-size: 14px;">Customer service siap membantu 24/7</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: grid; gap: 12px;">
                    @if($vehicle->status == 'tersedia')
                        <a href="{{ route('customer.rentals.create', $vehicle) }}" 
                           class="btn-action-primary">
                            <i class="fas fa-rocket" style="margin-right: 6px;"></i> Sewa Sekarang
                        </a>
                    @else
                        <button disabled
                                style="display: block; width: 100%; padding: 16px; text-align: center; background: var(--color-bg-light); color: var(--color-text-light); border-radius: 10px; font-weight: 700; font-size: 18px; border: none; cursor: not-allowed;">
                            <i class="fas fa-times"></i> Kendaraan Tidak Tersedia
                        </button>
                    @endif
                    
                    <a href="{{ route('customer.home') }}" class="btn-action-secondary">
                        <i class="fas fa-list" style="margin-right: 6px;"></i> Lihat Kendaraan Lain
                    </a>
                </div>

                <!-- Safety Notice -->
                <div style="margin-top: 24px;" class="notice-box">
                    <div style="display: flex; align-items: start;">
                        <i class="fas fa-info-circle" style="font-size: 20px; margin-right: 12px;"></i>
                        <div>
                            <div class="notice-title" style="font-weight: 600; margin-bottom: 4px; font-size: 14px;">
                                Informasi Penting
                            </div>
                            <p class="notice-text" style="font-size: 13px; line-height: 1.5; margin: 0;">
                                Pastikan Anda memiliki SIM yang masih berlaku dan KTP untuk proses verifikasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.customer>