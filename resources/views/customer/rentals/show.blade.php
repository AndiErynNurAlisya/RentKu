<x-layouts.customer title="Detail Booking">

    {{-- CUSTOM STYLES --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
            --color-dark-text: #111827;
            --color-info-bg: #f4d0d0; /* Very light Red for accents */
            --color-total: #34495e; /* Darker secondary for totals */
        }
        .text-primary { color: var(--color-primary) !important; }
        .text-secondary { color: var(--color-secondary) !important; }
        .bg-primary-gradient { 
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%) !important; 
        }
        
        /* --- Alert Messages (Error/Success) --- */
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
        .btn-back {
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
        .btn-back:hover {
            border-color: var(--color-secondary) !important; 
            color: var(--color-secondary) !important;
        }

        /* --- Header Status Card --- */
        .header-card {
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%) !important;
            border-radius: 16px; 
            padding: 40px; 
            margin-bottom: 32px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            color: white;
        }
        .status-badge {
            padding: 16px 28px; 
            border-radius: 50px; 
            text-align: center; 
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            font-weight: 700;
        }
        .status-badge .icon { font-size: 32px; margin-bottom: 8px; }
        .status-badge .text { font-size: 18px; }
        
        .status-pending { background: rgba(231, 76, 60, 0.2); } /* Primary Red light */
        .status-active { background: rgba(44, 62, 80, 0.2); } /* Secondary Dark light */
        .status-completed { background: rgba(44, 62, 80, 0.2); } 
        .status-cancelled { background: rgba(231, 76, 60, 0.2); }

        /* --- Info Details --- */
        .info-card {
            background: white; 
            border-radius: 16px; 
            padding: 32px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .info-card h3 { 
            font-size: 20px; 
            font-weight: 700; 
            color: var(--color-dark-text); 
            margin-bottom: 24px; 
            padding-bottom: 16px; 
            border-bottom: 2px solid var(--color-bg-light); 
        }
        .detail-row {
            display: flex; 
            justify-content: space-between; 
            padding: 12px 0; 
            border-bottom: 1px solid var(--color-bg-light);
        }
        .detail-row span:first-child { 
            color: var(--color-text-light); 
            font-weight: 500; 
        }
        .detail-row span:last-child { 
            font-weight: 600; 
            color: var(--color-dark-text); 
        }
        
        /* Total Price Section */
        .total-price-box {
            background: var(--color-info-bg); 
            padding: 20px; 
            border-radius: 10px; 
            margin-top: 12px;
            border: 1px solid var(--color-primary);
        }
        .total-price-box span:last-child {
            color: var(--color-primary); 
            font-size: 28px;
        }

        /* Notes Box */
        .notes-box {
            background: var(--color-bg-light); 
            border-left: 4px solid var(--color-secondary);
            color: var(--color-secondary);
        }

        /* --- Damage Reports --- */
        .damage-item {
            padding: 20px; 
            background: var(--color-bg-light); 
            border-radius: 10px; 
            margin-bottom: 16px; 
            border-left: 4px solid var(--color-primary); /* Use Primary Red for warning */
        }
        .damage-item h4 {
            color: var(--color-secondary);
        }
        .damage-cost {
            font-weight: 700; 
            color: var(--color-primary); 
            font-size: 18px;
        }
        .damage-meta {
            color: var(--color-text-light);
        }
        .damage-image {
            width: 160px; 
            height: 120px; 
            object-fit: cover; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* --- Pending Action --- */
        .pending-action-card {
            background: white; 
            border-radius: 16px; 
            padding: 28px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.06); 
            border: 2px solid var(--color-info-bg);
        }
        .pending-action-card h3 { color: var(--color-secondary); }
        .pending-action-card p { color: var(--color-text-light); }
        
        .btn-cancel-action {
            padding: 14px 28px; 
            background: var(--color-primary); 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-weight: 700; 
            font-size: 15px; 
            cursor: pointer; 
            transition: all 0.3s; 
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        }
        .btn-cancel-action:hover {
            background: #c0392b; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
        }
    </style>

    @if (session('error'))
        <div class="alert-custom alert-error">
            <i class="fas fa-times-circle text-primary"></i>
            <span style="font-weight: 500;">{{ session('error') }}</span>
        </div>
    @endif
    
    @if (session('success'))
        <div class="alert-custom alert-success">
            <i class="fas fa-check-circle text-secondary"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Back Button -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('customer.rentals.index') }}" class="btn-back">
            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>
            Kembali ke Riwayat
        </a>
    </div>

    <!-- Header Card with Status -->
    <div class="header-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Booking ID</div>
                <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 4px;">{{ $rental->rental_code }}</h1>
                <div style="font-size: 16px; opacity: 0.95;">{{ $rental->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
            <div>
                @if($rental->status == 'pending')
                    <div class="status-badge status-pending">
                        <div class="icon"><i class="fas fa-clock"></i></div>
                        <div class="text">Menunggu Konfirmasi</div>
                    </div>
                @elseif($rental->status == 'active')
                    <div class="status-badge status-active">
                        <div class="icon"><i class="fas fa-key"></i></div>
                        <div class="text">Sedang Berjalan</div>
                    </div>
                @elseif($rental->status == 'completed')
                    <div class="status-badge status-completed">
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                        <div class="text">Selesai</div>
                    </div>
                @else
                    <div class="status-badge status-cancelled">
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                        <div class="text">Dibatalkan</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
        
        <!-- Left Column: Vehicle Information -->
        <div class="info-card">
            <h3 style="color: var(--color-secondary);">
                <i class="fas fa-car-side" style="margin-right: 8px;"></i> Informasi Kendaraan
            </h3>

            @if($rental->vehicle->image)
                <div style="border-radius: 12px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <img src="{{ asset('storage/' . $rental->vehicle->image) }}" alt="{{ $rental->vehicle->brand }}" 
                         style="width: 100%; height: 240px; object-fit: cover;">
                </div>
            @endif

            <div style="display: grid; gap: 16px;">
                <div class="detail-row">
                    <span style="font-size: 15px;">Kendaraan</span>
                    <span style="font-size: 15px;">{{ $rental->vehicle->brand }} {{ $rental->vehicle->type }}</span>
                </div>
                
                <div class="detail-row">
                    <span style="font-size: 15px;">Plat Nomor</span>
                    <span style="font-size: 15px;">{{ $rental->vehicle->plate_number }}</span>
                </div>
                
                <div class="detail-row" style="border-bottom: none;">
                    <span style="font-size: 15px;">Kategori</span>
                    <span style="font-size: 15px;">
                        <i class="fas fa-{{ $rental->vehicle->category == 'motor' ? 'motorcycle' : 'car' }}" style="margin-right: 4px;"></i> {{ $rental->vehicle->category == 'motor' ? 'Motor' : 'Mobil' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Column: Rental Details -->
        <div class="info-card">
            <h3 style="color: var(--color-secondary);">
                <i class="fas fa-clipboard-list" style="margin-right: 8px;"></i> Detail Sewa
            </h3>

            <div style="display: grid; gap: 16px;">
                <div class="detail-row">
                    <span style="font-size: 15px;">Tanggal Booking</span>
                    <span style="font-size: 15px;">{{ $rental->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="detail-row">
                    <span style="font-size: 15px;">Tanggal Mulai</span>
                    <span style="font-size: 15px;">{{ $rental->start_date->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span style="font-size: 15px;">Tanggal Selesai</span>
                    <span style="font-size: 15px;">{{ $rental->end_date->format('d/m/Y') }}</span>
                </div>
                
                @if($rental->actual_return_date)
                <div class="detail-row">
                    <span style="font-size: 15px;">Tanggal Kembali Aktual</span>
                    <span style="font-size: 15px;">{{ $rental->actual_return_date->format('d/m/Y') }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span style="font-size: 15px;">Durasi</span>
                    <span style="font-size: 15px;">{{ $rental->total_days }} hari</span>
                </div>
                
                <div class="detail-row" style="border-bottom: none;">
                    <span style="font-size: 15px;">Harga per Hari</span>
                    <span style="font-size: 15px;">Rp {{ number_format($rental->price_per_day, 0, ',', '.') }}</span>
                </div>
                
                <div class="total-price-box">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 18px; font-weight: 700; color: var(--color-dark-text);">Total Harga</span>
                        <span style="font-size: 28px; font-weight: 700;">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($rental->notes)
                <div style="margin-top: 8px; padding: 16px; border-radius: 8px; border-left: 4px solid var(--color-secondary);" class="notes-box">
                    <div style="font-size: 13px; color: var(--color-text-light); margin-bottom: 6px; font-weight: 600;">Catatan:</div>
                    <div style="color: var(--color-secondary); font-size: 14px; line-height: 1.6;">{{ $rental->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Damage Reports -->
    @if($rental->damages->count() > 0)
    <div class="info-card">
        <h3 style="color: var(--color-primary);">
            <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> Laporan Kerusakan
        </h3>
        
        @foreach($rental->damages as $damage)
        <div class="damage-item">
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: var(--color-secondary);">
                        {{ $damage->description }}
                    </h4>
                    <div style="display: flex; gap: 24px; margin-bottom: 8px;">
                        <div>
                            <span style="font-size: 13px; color: var(--color-text-light);">Biaya Kerusakan:</span>
                            <span class="damage-cost" style="margin-left: 4px;">
                                Rp {{ number_format($damage->damage_cost, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div class="damage-meta" style="font-size: 13px;">
                        <i class="fas fa-calendar"></i> Dilaporkan: {{ $damage->reported_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                
                @if($damage->image)
                <div style="flex-shrink: 0;">
                    <img src="{{ asset('storage/' . $damage->image) }}" alt="Kerusakan" class="damage-image">
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Pending Status Action -->
    @if($rental->status == 'pending')
    <div class="pending-action-card" style="margin-top: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; margin-bottom: 8px;">
                    <i class="fas fa-clock" style="font-size: 24px; margin-right: 12px; color: var(--color-secondary);"></i>
                    <h3 style="font-size: 18px; font-weight: 700; color: var(--color-secondary); margin: 0;">Menunggu Konfirmasi Admin</h3>
                </div>
                <p style="font-size: 15px; margin: 0; line-height: 1.6;">
                    Booking Anda sedang diproses oleh admin. Anda masih dapat membatalkan pemesanan ini sebelum dikonfirmasi.
                </p>
            </div>
            
            <form action="{{ route('customer.rentals.cancel', $rental) }}" method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini? Status kendaraan akan dikembalikan menjadi tersedia.');"
                  style="margin-left: 24px;">
                @csrf
                <button type="submit" class="btn-cancel-action">
                    <i class="fas fa-trash"></i> Batalkan Pemesanan
                </button>
            </form>
        </div>
    </div>
    @endif

</x-layouts.customer>