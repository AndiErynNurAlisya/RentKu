@extends('layouts.admin')

@section('content')

    {{-- Custom Styles (omitted for brevity, assume the previous style block is here) --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
        }
        /* ... styles ... */

        .stat-card {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--color-bg-light);
            display: flex;
            flex-direction: column;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card h3 {
            font-size: 1rem;
            color: var(--color-secondary);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        .text-detail {
            font-size: 0.8rem;
            color: var(--color-text-light);
            margin-top: 0.5rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-top: 2rem;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #ecf0f1;
        }
        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-secondary);
            margin: 0;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .card table {
            width: 100%;
            border-collapse: collapse;
        }
        .card th, .card td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
            font-size: 0.9rem;
        }
        .card th {
            color: var(--color-secondary);
            background-color: #f9fbfd;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* --- Status Badges (Using Primary/Secondary Colors Only) --- */
        .badge {
            padding: 0.4em 0.8em;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            font-size: 0.8rem;
            text-transform: capitalize;
        }
        /* Pending (Warning - Light Red Background, Primary Text) */
        .badge-warning { background-color: #f4d0d0; color: var(--color-primary); }
        /* Active (Info - Light Grey Background, Secondary Text) */
        .badge-info { background-color: #f9fbfd; color: var(--color-secondary); border: 1px solid #ecf0f1;}
        /* Completed (Success - Lighter Red Background, Secondary Text) */
        .badge-success { background-color: #f4d0d0; color: var(--color-secondary); }
        /* Cancelled (Danger - Primary Red Background, White Text) */
        .badge-danger { background-color: var(--color-primary); color: #ffffff; }

        /* --- Quick Actions --- */
        .quick-action-link {
            padding: 2rem;
            border-radius: 0.75rem;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .quick-action-link:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        .quick-action-icon {
            font-size: 2.25rem;
            margin-bottom: 0.75rem;
        }
        .quick-action-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }
        .quick-action-description {
            font-size: 0.9rem;
            margin: 0;
        }

        /* --- Alert --- */
        .alert-custom {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
            background-color: #f9fbfd; /* Light Background */
        }
        .alert-pending-warning {
            border-left: 6px solid var(--color-primary); /* Primary Red Border */
            color: var(--color-secondary); /* Secondary Dark Text */
        }
        .alert-pending-warning i {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: var(--color-primary);
        }
        .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
    margin: 2rem 0;
}

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }

    .card-header h3 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .stat-main {
        margin-bottom: 20px;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: baseline;
        gap: 10px;
    }

    .trend-indicator {
        font-size: 0.85rem;
        background: #10b981;
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .progress-wrapper {
        height: 6px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 3px;
        transition: width 1s ease-in-out;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .text-detail {
        font-size: 0.9rem;
        color: #666;
        display: flex;
        align-items: center;
    }

    .more-info {
        color: #999;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .more-info:hover {
        color: var(--color-primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-value {
            font-size: 2rem;
        }
    }


    </style>

    {{-- End Custom Styles --}}

    @if(isset($pendingRentalsCount) && $pendingRentalsCount > 0)
        <div class="alert-custom alert-pending-warning">
            <i class="fas fa-bell"></i>
            <div style="flex: 1;">
                <strong style="font-size: 16px; display: block; margin-bottom: 4px; color: var(--color-secondary);">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 4px; color: var(--color-primary);"></i>
                    {{ $pendingRentalsCount }} Pesanan Menunggu Konfirmasi
                </strong>
                <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">
                    Anda memiliki transaksi rental yang perlu ditinjau segera.
                    <a href="{{ route('admin.rentals.index') }}" style="color: var(--color-primary); font-weight: 700; text-decoration: underline; margin-left: 8px;">
                        Tinjau Sekarang &rarr;
                    </a>
                </p>
            </div>
        </div>
    @endif

    <div class="stats-grid">
        @php
            $cards = [
                [
                    'title' => 'Total Kendaraan',
                    'value' => $totalVehicles,
                    'icon' => 'fas fa-car',
                    'color' => 'var(--color-secondary)',
                    'description' => 'Seluruh armada'
                ],
                [
                    'title' => 'Tersedia',
                    'value' => $availableVehicles,
                    'icon' => 'fas fa-check-circle',
                    'color' => 'var(--color-primary)',
                    'description' => 'Siap disewakan'
                ],
                [
                    'title' => 'Sedang Disewa',
                    'value' => $rentedVehicles,
                    'icon' => 'fas fa-key',
                    'color' => 'var(--color-secondary)',
                    'description' => 'Dalam penggunaan'
                ],
                [
                    'title' => 'Transaksi Bulan Ini',
                    'value' => $monthlyRentals,
                    'icon' => 'fas fa-calendar-alt',
                    'color' => 'var(--color-primary)',
                    'description' => date('F Y')
                ]
            ];
        @endphp

        @foreach($cards as $index => $card)
        <div class="stat-card animated-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
            <div class="card-header">
                <div class="icon-wrapper" style="background: {{ $card['color'] }}20;">
                    <i class="{{ $card['icon'] }}" style="color: {{ $card['color'] }};"></i>
                </div>
                <h3>{{ $card['title'] }}</h3>
            </div>
            
            <div class="stat-main">
                <div class="stat-value" style="color: {{ $card['color'] }};">
                    {{ $card['value'] }}
                    @if($loop->index == 3)
                    <span class="trend-indicator">
                        <i class="fas fa-arrow-up"></i> 12%
                    </span>
                    @endif
                </div>
                
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: {{ ($card['value'] / ($totalVehicles ?: 1)) * 100 }}%; background: {{ $card['color'] }};"></div>
                </div>
            </div>
            
            <div class="card-footer">
                <span class="text-detail">
                    <i class="{{ $card['icon'] }}" style="margin-right: 6px;"></i>
                    {{ $card['description'] }}
                </span>
                <span class="more-info">
                    <i class="fas fa-info-circle"></i>
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-receipt" style="margin-right: 8px; color: var(--color-secondary);"></i> Transaksi Terbaru</h2>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-primary btn-sm" style="background-color: var(--color-primary); border-color: var(--color-primary);">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Tanggal Sewa</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRentals as $rental)
                    <tr>
                        <td>
                            <strong style="color: var(--color-secondary);">{{ $rental->rental_code }}</strong>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--color-secondary);">{{ $rental->user->name }}</div>
                            <div style="font-size: 13px; color: var(--color-text-light);">{{ $rental->user->phone }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--color-secondary);">{{ $rental->vehicle->brand }} {{ $rental->vehicle->type }}</div>
                            <div style="font-size: 13px; color: var(--color-text-light);">{{ $rental->vehicle->plate_number }}</div>
                        </td>
                        <td>
                            <div>{{ $rental->start_date->format('d/m/Y') }}</div>
                            <div style="font-size: 13px; color: var(--color-text-light);">{{ $rental->total_days }} hari</div>
                        </td>
                        <td>
                            @if($rental->status == 'pending')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock" style="margin-right: 4px;"></i>
                                    Pending
                                </span>
                            @elseif($rental->status == 'active')
                                <span class="badge badge-info">
                                    <i class="fas fa-play-circle" style="margin-right: 4px;"></i>
                                    Aktif
                                </span>
                            @elseif($rental->status == 'completed')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle" style="margin-right: 4px;"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle" style="margin-right: 4px;"></i>
                                    Dibatalkan
                                </span>
                            @endif
                        </td>
                        <td>
                            <strong style="color: var(--color-primary);">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-primary btn-sm" style="background-color: var(--color-secondary); border-color: var(--color-secondary);">
                                <i class="fas fa-eye" style="margin-right: 4px;"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px 20px;">
                            <div style="font-size: 48px; opacity: 0.3; margin-bottom: 12px; color: var(--color-text-light);">
                                <i class="fas fa-box-open"></i> {{-- ICON BARU --}}
                            </div>
                            <div style="color: var(--color-text-light); font-size: 16px;">Belum ada transaksi terbaru.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem;">

        {{-- Quick Action: Kelola Transaksi (Light Red Background) --}}
        <a href="{{ route('admin.rentals.index') }}" class="quick-action-link"
           style="background: linear-gradient(135deg, #ffffff 0%, #f4d0d0 100%);"
           onmouseover="this.style.transform='translateY(-4px)'"
           onmouseout="this.style.transform='translateY(0)'">
            <div class="quick-action-icon" style="color: var(--color-primary);"><i class="fas fa-file-invoice"></i></div>
            <h3 class="quick-action-title" style="color: var(--color-secondary);">Kelola Transaksi</h3>
            <p class="quick-action-description" style="color: var(--color-text-light);">Lihat dan kelola semua transaksi rental</p>
        </a>

        {{-- Quick Action: Kelola Kendaraan (White Background) --}}
        <a href="{{ route('admin.vehicles.index') }}" class="quick-action-link"
           style="background: linear-gradient(135deg, #f9fbfd 0%, #ffffff 100%);"
           onmouseover="this.style.transform='translateY(-4px)'"
           onmouseout="this.style.transform='translateY(0)'">
            <div class="quick-action-icon" style="color: var(--color-secondary);"><i class="fas fa-car-side"></i></div>
            <h3 class="quick-action-title" style="color: var(--color-secondary);">Kelola Kendaraan</h3>
            <p class="quick-action-description" style="color: var(--color-text-light);">Tambah, edit, atau hapus kendaraan</p>
        </a>

        {{-- Quick Action: Data Pelanggan (Light Red Background) --}}
        <a href="{{ route('admin.customers.index') }}" class="quick-action-link"
           style="background: linear-gradient(135deg, #ffffff 0%, #f4d0d0 100%);"
           onmouseover="this.style.transform='translateY(-4px)'"
           onmouseout="this.style.transform='translateY(0)'">
            <div class="quick-action-icon" style="color: var(--color-primary);"><i class="fas fa-users"></i></div>
            <h3 class="quick-action-title" style="color: var(--color-secondary);">Data Pelanggan</h3>
            <p class="quick-action-description" style="color: var(--color-text-light);">Lihat informasi semua pelanggan</p>
        </a>
    </div>

@endsection