<x-layouts.customer title="Beranda">

    {{-- CUSTOM STYLES (for color consistency) --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
            --color-dark-text: #111827;
            --color-info-bg: #f4d0d0; /* Very light Red for accents */
        }
        .text-primary { color: var(--color-primary) !important; }
        .text-secondary { color: var(--color-secondary) !important; }
        .bg-primary-gradient { 
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%) !important; 
        }
        .bg-accent-gradient { 
            background: linear-gradient(135deg, var(--color-primary) 0%, #c0392b 100%) !important; 
        }
        .form-control {
            border: 1.5px solid #d8dbe0 !important;
            color: var(--color-secondary) !important;
        }
        .stat-indicator {
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
        }
        .vehicle-card {
            border: 1px solid var(--color-bg-light);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s;
        }
        .icon-circle {
            width: 80px; height: 80px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 20px; 
            font-size: 36px; 
            color: var(--color-primary); 
            border: 2px solid var(--color-primary);
        }
    </style>
    
    <!-- Hero Section -->
    <div class="bg-primary-gradient" style="border-radius: 16px; padding: 60px 40px; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div style="max-width: 800px; margin: 0 auto; text-align: center; color: white;">
            <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 16px; letter-spacing: -0.5px;">
                Rental Kendaraan Terpercaya
            </h1>
            <p style="font-size: 20px; opacity: 0.95; margin-bottom: 0; font-weight: 300;">
                Sewa mobil & motor mudah, aman, dan nyaman untuk perjalanan Anda
            </p>
        </div>
    </div>

    <!-- Trust Indicators (EMOJI -> ICON) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
        <div class="stat-indicator">
            <div style="font-size: 36px; margin-bottom: 8px;"><i class="fas fa-handshake text-secondary"></i></div> {{-- ✅ -> Handshake --}}
            <div style="font-size: 24px; font-weight: 700;" class="text-secondary">100%</div>
            <div style="color: var(--color-text-light); font-size: 14px;">Terpercaya</div>
        </div>
        <div class="stat-indicator">
            <div style="font-size: 36px; margin-bottom: 8px;"><i class="fas fa-car text-secondary"></i></div> {{-- 🚗 -> Car --}}
            <div style="font-size: 24px; font-weight: 700;" class="text-secondary">{{ \App\Models\Vehicle::count() }}+</div>
            <div style="color: var(--color-text-light); font-size: 14px;">Kendaraan</div>
        </div>
        <div class="stat-indicator">
            <div style="font-size: 36px; margin-bottom: 8px;"><i class="fas fa-users text-secondary"></i></div> {{-- 👥 -> Users --}}
            <div style="font-size: 24px; font-weight: 700;" class="text-secondary">{{ \App\Models\User::where('role', 'customer')->count() }}+</div>
            <div style="color: var(--color-text-light); font-size: 14px;">Pelanggan</div>
        </div>
        <div class="stat-indicator">
            <div style="font-size: 36px; margin-bottom: 8px;"><i class="fas fa-headset text-secondary"></i></div> {{-- ⚡ -> Headset/Support --}}
            <div style="font-size: 24px; font-weight: 700;" class="text-secondary">24/7</div>
            <div style="color: var(--color-text-light); font-size: 14px;">Layanan</div>
        </div>
    </div>

    <!-- Search Filter Card -->
    <div style="background: white; border-radius: 16px; padding: 32px; margin-bottom: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 24px; color: var(--color-dark-text);">
            <i class="fas fa-search text-secondary" style="margin-right: 8px;"></i> Cari Kendaraan yang Tersedia
        </h3>
        
        <form method="GET" action="{{ route('customer.home') }}">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 500; color: var(--color-secondary); margin-bottom: 8px;">
                        Kategori Kendaraan
                    </label>
                    <select name="category" class="form-control" style="width: 100%; padding: 12px 16px; border-radius: 8px; font-size: 15px; background: white;">
                        <option value="">Semua Kategori</option>
                        <option value="motor" {{ request('category') == 'motor' ? 'selected' : '' }}>🛵 Motor</option>
                        <option value="mobil" {{ request('category') == 'mobil' ? 'selected' : '' }}>🚘 Mobil</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 500; color: var(--color-secondary); margin-bottom: 8px;">
                        Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" min="{{ date('Y-m-d') }}" style="width: 100%; padding: 12px 16px; border-radius: 8px; font-size: 15px;">
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 500; color: var(--color-secondary); margin-bottom: 8px;">
                        Tanggal Selesai
                    </label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" min="{{ date('Y-m-d') }}" style="width: 100%; padding: 12px 16px; border-radius: 8px; font-size: 15px;">
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary bg-primary-gradient" style="flex: 1; padding: 14px; font-size: 16px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; color: white; transition: background 0.2s, transform 0.2s;"
                        onmouseover="this.style.transform='scale(1.02)'"
                        onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-search" style="margin-right: 6px;"></i> Cari Kendaraan
                </button>
                
                @if(request()->filled(['category']) || request()->filled(['start_date']) || request()->filled(['end_date']))
                <a href="{{ route('customer.home') }}" class="btn btn-secondary" style="padding: 14px 24px; font-size: 16px; font-weight: 600; border-radius: 8px; background: var(--color-bg-light); color: var(--color-secondary); border: none; text-decoration: none; display: inline-flex; align-items: center;">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Results Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 28px; font-weight: 700; color: var(--color-dark-text); margin: 0;">
            @if(request('start_date') && request('end_date'))
                Kendaraan Tersedia
                <span style="font-size: 16px; font-weight: 400; color: var(--color-text-light);">
                    ({{ \Carbon\Carbon::parse(request('start_date'))->format('d M') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }})
                </span>
            @else
                Kendaraan Tersedia
            @endif
        </h2>
        <div style="color: var(--color-text-light); font-size: 15px;">
            {{ $vehicles->count() }} kendaraan ditemukan
        </div>
    </div>

    <!-- Vehicle Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; margin-bottom: 40px;">
        @forelse($vehicles as $vehicle)
        <div class="vehicle-card" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'; this.style.transform='translateY(0)';">
            
            <!-- Image -->
            <div style="position: relative; width: 100%; height: 220px; overflow: hidden; background: var(--color-bg-light);">
                @if($vehicle->image)
                    <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->brand }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 64px;">
                        <i class="fas fa-{{ $vehicle->category == 'motor' ? 'motorcycle' : 'car' }} text-secondary" style="opacity: 0.6;"></i>
                    </div>
                @endif
                
                <!-- Category Badge (EMOJI -> ICON) -->
                <div style="position: absolute; top: 12px; left: 12px; background: rgba(255,255,255,0.95); padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; color: var(--color-secondary); backdrop-filter: blur(8px); border: 1px solid var(--color-bg-light);">
                    <i class="fas fa-{{ $vehicle->category == 'motor' ? 'motorcycle' : 'car' }}" style="margin-right: 4px;"></i> {{ $vehicle->category == 'motor' ? 'Motor' : 'Mobil' }}
                </div>
            </div>

            <!-- Card Body -->
            <div style="padding: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 8px;">
                    {{ $vehicle->brand }} {{ $vehicle->type }}
                </h3>
                
                <div style="display: flex; align-items: center; color: var(--color-text-light); font-size: 14px; margin-bottom: 16px;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 4px;"></i>
                    {{ $vehicle->plate_number }}
                </div>

                <!-- Price -->
                <div style="background: var(--color-info-bg); padding: 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid var(--color-primary);">
                    <div style="font-size: 13px; color: var(--color-secondary); margin-bottom: 4px;">Harga Sewa</div>
                    <div style="font-size: 24px; font-weight: 700;" class="text-primary">
                        Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                        <span style="font-size: 14px; font-weight: 400; color: var(--color-text-light);">/hari</span>
                    </div>
                </div>

                <!-- Action Button (EMOJI -> ICON) -->
                @if(request('start_date') && request('end_date'))
                    <a href="{{ route('customer.rentals.create', $vehicle) }}?start_date={{ request('start_date') }}&end_date={{ request('end_date') }}" 
                        class="bg-accent-gradient"
                       style="display: block; width: 100%; padding: 12px; text-align: center; color: white; border-radius: 8px; font-weight: 600; text-decoration: none; transition: transform 0.2s;"
                       onmouseover="this.style.transform='scale(1.02)'"
                       onmouseout="this.style.transform='scale(1)'">
                        <i class="fas fa-rocket" style="margin-right: 6px;"></i> Booking Sekarang
                    </a>
                @else
                    <a href="{{ route('customer.vehicles.show', $vehicle->id) }}" 
                        class="bg-primary-gradient"
                       style="display: block; width: 100%; padding: 12px; text-align: center; color: white; border-radius: 8px; font-weight: 600; text-decoration: none; transition: transform 0.2s;"
                       onmouseover="this.style.transform='scale(1.02)'"
                       onmouseout="this.style.transform='scale(1)'">
                        Lihat Detail →
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; background: white; border-radius: 16px; padding: 60px 40px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div style="font-size: 72px; margin-bottom: 20px; opacity: 0.5;">
                 <i class="fas fa-search-minus text-secondary" style="opacity: 0.5;"></i> {{-- 🔍 -> Search Minus --}}
            </div>
            @if(request('start_date') && request('end_date'))
                <h3 style="font-size: 24px; font-weight: 600; color: var(--color-dark-text); margin-bottom: 12px;">Tidak Ada Kendaraan Tersedia</h3>
                <p style="font-size: 16px; color: var(--color-text-light); margin-bottom: 24px;">Maaf, tidak ada kendaraan yang tersedia untuk rentang tanggal yang Anda pilih.</p>
                <a href="{{ route('customer.home') }}" class="btn btn-primary bg-primary-gradient" style="display: inline-block; padding: 12px 32px; font-size: 16px; font-weight: 600; border-radius: 8px; color: white; text-decoration: none;">
                    Coba Tanggal Lain
                </a>
            @else
                <h3 style="font-size: 24px; font-weight: 600; color: var(--color-dark-text); margin-bottom: 12px;">Belum Ada Kendaraan</h3>
                <p style="font-size: 16px; color: var(--color-text-light);">Tidak ada kendaraan yang tersedia saat ini.</p>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Why Choose Us Section (EMOJI -> ICON) -->
    <div style="background: var(--color-bg-light); border-radius: 16px; padding: 48px 40px; margin-top: 60px;">
        <h2 style="text-align: center; font-size: 32px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 40px;">
            Kenapa Memilih RentKu?
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px;">
            <div style="text-align: center;">
                <div class="icon-circle" style="background: var(--color-info-bg);">
                    <i class="fas fa-tools"></i> {{-- ✅ -> Tools (Terawat) --}}
                </div>
                <h3 style="font-size: 18px; font-weight: 600; color: var(--color-dark-text); margin-bottom: 8px;">Kendaraan Terawat</h3>
                <p style="color: var(--color-text-light); font-size: 15px; line-height: 1.6;">Semua kendaraan dalam kondisi prima dan terawat dengan baik</p>
            </div>

            <div style="text-align: center;">
                <div class="icon-circle" style="background: var(--color-info-bg);">
                    <i class="fas fa-tag"></i> {{-- 💰 -> Tag (Harga) --}}
                </div>
                <h3 style="font-size: 18px; font-weight: 600; color: var(--color-dark-text); margin-bottom: 8px;">Harga Terjangkau</h3>
                <p style="color: var(--color-text-light); font-size: 15px; line-height: 1.6;">Harga kompetitif tanpa biaya tersembunyi</p>
            </div>

            <div style="text-align: center;">
                <div class="icon-circle" style="background: var(--color-info-bg);">
                    <i class="fas fa-tachometer-alt"></i> {{-- 🕐 -> Tachometer (Cepat/Proses) --}}
                </div>
                <h3 style="font-size: 18px; font-weight: 600; color: var(--color-dark-text); margin-bottom: 8px;">Proses Cepat</h3>
                <p style="color: var(--color-text-light); font-size: 15px; line-height: 1.6;">Booking mudah dan proses konfirmasi yang cepat</p>
            </div>
        </div>
    </div>

</x-layouts.customer>