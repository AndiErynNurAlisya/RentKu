<x-layouts.customer title="Riwayat Sewa">

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
        
        /* --- Filter Tabs --- */
        .tab-button {
            padding: 10px 20px; 
            border: 1.5px solid var(--color-bg-light); 
            border-radius: 8px; 
            font-weight: 600; 
            cursor: pointer;
            transition: all 0.2s;
            background: white;
            color: var(--color-secondary);
        }
        .tab-button.active {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }
        .tab-button:hover:not(.active) {
            background: var(--color-bg-light);
        }
        
        /* --- Rental Card --- */
        .rental-card {
            border: 1.5px solid var(--color-bg-light); 
            border-radius: 12px; 
            padding: 24px; 
            margin-bottom: 20px; 
            transition: all 0.3s; 
            background: white;
        }
        .rental-card:hover {
            border-color: var(--color-secondary) !important; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .vehicle-icon-wrapper {
            width: 80px; 
            height: 80px; 
            background: var(--color-info-bg); 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 36px;
            color: var(--color-secondary);
        }
        
        /* --- Status Badge Styling --- */
        .badge {
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }
        .badge i { margin-right: 4px; }
        
        .badge-pending { background: #f4d0d0; color: var(--color-primary); }
        .badge-active { background: var(--color-secondary); color: white; }
        .badge-completed { background: var(--color-bg-light); color: var(--color-secondary); }
        .badge-cancelled { background: var(--color-primary); color: white; }

        /* --- Stats Cards --- */
        .stat-box {
            border-radius: 12px; 
            padding: 24px; 
            text-align: center;
            border: 1px solid var(--color-bg-light);
        }
        .stat-box .stat-icon {
            font-size: 36px; 
            margin-bottom: 8px;
            color: var(--color-secondary);
        }
        .stat-box .stat-value {
            font-size: 28px; 
            font-weight: 700; 
            margin-bottom: 4px;
        }
        .stat-box-pending { background: var(--color-info-bg); }
        .stat-box-active { background: var(--color-bg-light); }
        .stat-box-completed { background: var(--color-info-bg); }
        
        /* --- Empty State --- */
        .empty-icon-wrapper {
            width: 120px; 
            height: 120px; 
            background: var(--color-bg-light); 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 24px; 
            font-size: 64px;
            color: var(--color-text-light);
            opacity: 0.8;
        }
    </style>

    <!-- Header Section -->
    <div class="bg-primary-gradient" style="border-radius: 16px; padding: 40px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; color: white;">
            <div>
                <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 8px;">Riwayat Sewa Saya</h1>
                <p style="opacity: 0.9; font-size: 16px; margin: 0;">Kelola semua transaksi rental kendaraan Anda</p>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 48px; font-weight: 700; margin-bottom: 4px;">{{ $rentals->total() }}</div>
                <div style="font-size: 14px; opacity: 0.9;">Total Transaksi</div>
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        
        <!-- Filter Tabs (Simple Buttons using new styling) -->
        <div style="display: flex; gap: 12px; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 2px solid var(--color-bg-light);">
            {{-- Note: These buttons are purely stylistic here as the actual filtering logic isn't shown --}}
            <button class="tab-button active">
                <i class="fas fa-list"></i> Semua
            </button>
            <button class="tab-button">
                <i class="fas fa-play-circle"></i> Aktif
            </button>
            <button class="tab-button">
                <i class="fas fa-check"></i> Selesai
            </button>
        </div>

        @forelse($rentals as $rental)
        <!-- Rental Card -->
        <div class="rental-card">
            
            <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center;">
                
                <!-- Vehicle Icon -->
                <div class="vehicle-icon-wrapper">
                    <i class="fas fa-{{ $rental->vehicle->category == 'motor' ? 'motorcycle' : 'car' }}"></i>
                </div>

                <!-- Rental Details -->
                <div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <h3 style="font-size: 20px; font-weight: 700; color: var(--color-dark-text); margin: 0;">
                            {{ $rental->vehicle->brand }} {{ $rental->vehicle->type }}
                        </h3>
                        @if($rental->status == 'pending')
                            <span class="badge badge-pending">
                                <i class="fas fa-clock"></i> Menunggu Konfirmasi
                            </span>
                        @elseif($rental->status == 'active')
                            <span class="badge badge-active">
                                <i class="fas fa-key"></i> Sedang Berjalan
                            </span>
                        @elseif($rental->status == 'completed')
                            <span class="badge badge-completed">
                                <i class="fas fa-check"></i> Selesai
                            </span>
                        @else
                            <span class="badge badge-cancelled">
                                <i class="fas fa-times"></i> Dibatalkan
                            </span>
                        @endif
                    </div>

                    <div style="color: var(--color-text-light); font-size: 14px; margin-bottom: 12px;">
                        <span style="font-weight: 600;" class="text-secondary">{{ $rental->rental_code }}</span> • {{ $rental->vehicle->plate_number }}
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, auto); gap: 24px; font-size: 14px;">
                        <div>
                            <span style="color: var(--color-text-light);"><i class="fas fa-calendar-alt"></i> Periode:</span>
                            <span style="font-weight: 600; color: var(--color-dark-text); margin-left: 4px;">
                                {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}
                            </span>
                        </div>
                        <div>
                            <span style="color: var(--color-text-light);"><i class="fas fa-hourglass-half"></i> Durasi:</span>
                            <span style="font-weight: 600; color: var(--color-dark-text); margin-left: 4px;">
                                {{ $rental->total_days }} hari
                            </span>
                        </div>
                        <div>
                            <span style="color: var(--color-text-light);"><i class="fas fa-wallet"></i> Total:</span>
                            <span style="font-weight: 700; color: var(--color-primary); margin-left: 4px; font-size: 16px;">
                                Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div>
                    <a href="{{ route('customer.rentals.show', $rental) }}" 
                        class="bg-primary-gradient"
                       style="display: inline-block; padding: 12px 24px; color: white; border-radius: 8px; font-weight: 600; text-decoration: none; transition: transform 0.2s;"
                       onmouseover="this.style.transform='scale(1.05)'"
                       onmouseout="this.style.transform='scale(1)'">
                        Lihat Detail &rarr;
                    </a>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div style="text-align: center; padding: 80px 40px;">
            <div class="empty-icon-wrapper">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 style="font-size: 24px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 12px;">
                Belum Ada Riwayat Sewa
            </h3>
            <p style="font-size: 16px; color: var(--color-text-light); margin-bottom: 28px; max-width: 400px; margin-left: auto; margin-right: auto;">
                Anda belum pernah melakukan transaksi rental kendaraan. Mulai perjalanan Anda sekarang!
            </p>
            <a href="{{ route('customer.home') }}" 
                class="bg-primary-gradient"
               style="display: inline-block; padding: 14px 32px; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; text-decoration: none; box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3); transition: all 0.3s;"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(44, 62, 80, 0.4)'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(44, 62, 80, 0.3)'">
                <i class="fas fa-rocket" style="margin-right: 6px;"></i> Mulai Sewa Kendaraan
            </a>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($rentals->hasPages())
        <div style="margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--color-bg-light);">
            {{ $rentals->links() }}
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    @if($rentals->total() > 0)
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 32px;">
        {{-- Pending --}}
        <div class="stat-box stat-box-pending" style="background: var(--color-info-bg);">
            <div class="stat-icon"><i class="fas fa-clock text-primary"></i></div>
            <div class="stat-value text-primary">
                {{ $rentals->where('status', 'pending')->count() }}
            </div>
            <div style="color: var(--color-secondary); font-size: 14px;">Menunggu Konfirmasi</div>
        </div>

        {{-- Active --}}
        <div class="stat-box stat-box-active" style="background: var(--color-bg-light);">
            <div class="stat-icon"><i class="fas fa-key text-secondary"></i></div>
            <div class="stat-value text-secondary">
                {{ $rentals->where('status', 'active')->count() }}
            </div>
            <div style="color: var(--color-text-light); font-size: 14px;">Sedang Berjalan</div>
        </div>

        {{-- Completed --}}
        <div class="stat-box stat-box-completed" style="background: var(--color-info-bg);">
            <div class="stat-icon"><i class="fas fa-check-circle text-primary"></i></div>
            <div class="stat-value text-primary">
                {{ $rentals->where('status', 'completed')->count() }}
            </div>
            <div style="color: var(--color-secondary); font-size: 14px;">Selesai</div>
        </div>
    </div>
    @endif

</x-layouts.customer>