@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --color-primary: #e74c3c;
            --color-secondary: #2c3e50;
            --color-text-light: #7f8c8d;
            --color-bg-light: #ecf0f1;
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
            --color-info: #3b82f6;
            --color-border: #e2e8f0;
        }

        /* Container Styles */
        .transactions-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-top: 1.5rem;
        }

        /* Header Styles */
        .transactions-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--color-border);
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-secondary);
            margin: 0;
        }

        .header-title i {
            color: var(--color-primary);
            font-size: 1.25rem;
        }

        /* Filter Section */
        .filter-section {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--color-border);
            background: #ffffff;
        }

        .filter-form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }

        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-text-light);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Controls */
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--color-secondary);
            background: #ffffff;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }

        /* Buttons */
        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            height: 48px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary) 0%, #c0392b 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(231, 76, 60, 0.2);
        }

        .btn-secondary {
            background: white;
            color: var(--color-secondary);
            border: 1px solid var(--color-border);
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: var(--color-primary);
            color: var(--color-primary);
            transform: translateY(-2px);
        }

        /* Stats Summary */
        .stats-summary {
            padding: 2rem;
            background: #f8fafc;
            border-bottom: 1px solid var(--color-border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--color-text-light);
            font-weight: 500;
        }

        /* Table Styles */
        .transactions-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .transactions-table thead {
            background: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .transactions-table th {
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--color-secondary);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--color-border);
            white-space: nowrap;
        }

        .transactions-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--color-border);
        }

        .transactions-table tbody tr:hover {
            background: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .transactions-table td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            color: #475569;
        }

        /* Booking Code */
        .booking-code {
            background: var(--color-secondary);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
        }

        /* Customer Info */
        .customer-name {
            font-weight: 700;
            color: var(--color-secondary);
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .customer-detail {
            font-size: 0.875rem;
            color: var(--color-text-light);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Vehicle Info */
        .vehicle-info {
            font-weight: 600;
            color: var(--color-secondary);
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .vehicle-detail {
            font-size: 0.875rem;
            color: var(--color-text-light);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Rental Period */
        .rental-period {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .rental-date {
            font-size: 0.95rem;
            color: var(--color-secondary);
            font-weight: 500;
        }

        .rental-duration {
            font-size: 0.875rem;
            color: var(--color-text-light);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Price */
        .price-amount {
            font-weight: 700;
            color: var(--color-primary);
            font-size: 1rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .status-active {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .status-completed {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        /* Action Button */
        .action-btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            background: linear-gradient(135deg, var(--color-primary) 0%, #c0392b 100%);
            color: white;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(231, 76, 60, 0.2);
        }

        /* Empty State */
        .empty-state {
            padding: 80px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 24px;
            color: var(--color-text-light);
            opacity: 0.2;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-secondary);
            margin-bottom: 16px;
        }

        .empty-subtitle {
            color: var(--color-text-light);
            margin-bottom: 32px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Pagination */
        .pagination-container {
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--color-border);
            display: flex;
            justify-content: center;
            background: #ffffff;
        }

        /* Responsive Table */
        @media (max-width: 1024px) {
            .transactions-table {
                display: block;
                overflow-x: auto;
            }
            
            .transactions-table th,
            .transactions-table td {
                min-width: 150px;
            }
        }
    </style>

    <!-- Main Container -->
    <div class="transactions-container">
        <!-- Header -->
        <div class="transactions-header">
            <div class="header-title">
                <i class="fas fa-receipt"></i>
                <h2>Daftar Transaksi Sewa</h2>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <div class="filter-group">
                    <label class="filter-label">Filter Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            <i class="fas fa-clock"></i> Pending
                        </option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            <i class="fas fa-play-circle"></i> Aktif
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            <i class="fas fa-check-circle"></i> Selesai
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            <i class="fas fa-times-circle"></i> Dibatalkan
                        </option>
                    </select>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                        Terapkan
                    </button>
                    
                    @if(request('status'))
                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Stats Summary -->
        <div class="stats-summary">
            <div class="stats-grid">
                <!-- Pending -->
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--color-warning);">
                        {{ $rentals->where('status', 'pending')->count() }}
                    </div>
                    <div class="stat-label">Pending</div>
                </div>

                <!-- Active -->
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--color-info);">
                        {{ $rentals->where('status', 'active')->count() }}
                    </div>
                    <div class="stat-label">Aktif</div>
                </div>

                <!-- Completed -->
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--color-success);">
                        {{ $rentals->where('status', 'completed')->count() }}
                    </div>
                    <div class="stat-label">Selesai</div>
                </div>

                <!-- Cancelled -->
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--color-danger);">
                        {{ $rentals->where('status', 'cancelled')->count() }}
                    </div>
                    <div class="stat-label">Dibatalkan</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Periode Sewa</th>
                        <th>Durasi</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentals as $rental)
                    <tr>
                        <!-- Booking Code -->
                        <td>
                            <span class="booking-code">{{ $rental->rental_code }}</span>
                        </td>

                        <!-- Customer -->
                        <td>
                            <div class="customer-name">{{ $rental->user->name }}</div>
                            <div class="customer-detail">
                                <i class="fas fa-phone"></i>
                                {{ $rental->user->phone }}
                            </div>
                        </td>

                        <!-- Vehicle -->
                        <td>
                            <div class="vehicle-info">
                                {{ $rental->vehicle->brand }} {{ $rental->vehicle->type }}
                            </div>
                            <div class="vehicle-detail">
                                <i class="fas fa-id-card"></i>
                                {{ $rental->vehicle->plate_number }}
                            </div>
                        </td>

                        <!-- Rental Period -->
                        <td>
                            <div class="rental-period">
                                <span class="rental-date">{{ $rental->start_date->format('d/m/Y') }}</span>
                                <span class="rental-duration">
                                    <i class="fas fa-arrow-right"></i>
                                    {{ $rental->end_date->format('d/m/Y') }}
                                </span>
                            </div>
                        </td>

                        <!-- Duration -->
                        <td>
                            <div style="font-weight: 600; color: var(--color-secondary);">
                                {{ $rental->total_days }} hari
                            </div>
                        </td>

                        <!-- Total Price -->
                        <td>
                            <div class="price-amount">
                                Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                            </div>
                        </td>

                        <!-- Status -->
                        <td>
                            @if($rental->status == 'pending')
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i>
                                    Pending
                                </span>
                            @elseif($rental->status == 'active')
                                <span class="status-badge status-active">
                                    <i class="fas fa-play-circle"></i>
                                    Aktif
                                </span>
                            @elseif($rental->status == 'completed')
                                <span class="status-badge status-completed">
                                    <i class="fas fa-check-circle"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="status-badge status-cancelled">
                                    <i class="fas fa-times-circle"></i>
                                    Dibatalkan
                                </span>
                            @endif
                        </td>

                        <!-- Action -->
                        <td>
                            <a href="{{ route('admin.rentals.show', $rental) }}" class="action-btn">
                                <i class="fas fa-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                                <h3 class="empty-title">
                                    @if(request('status'))
                                        Tidak Ada Transaksi {{ ucfirst(request('status')) }}
                                    @else
                                        Belum Ada Transaksi
                                    @endif
                                </h3>
                                <p class="empty-subtitle">
                                    @if(request('status'))
                                        Tidak ada transaksi dengan status "{{ ucfirst(request('status')) }}" yang ditemukan.
                                    @else
                                        Mulai dengan menyetujui transaksi pertama untuk melihatnya di sini.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($rentals->hasPages())
        <div class="pagination-container">
            {{ $rentals->links() }}
        </div>
        @endif
    </div>

    <!-- Optional JavaScript for Interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('.transactions-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.cursor = 'pointer';
                });
                
                row.addEventListener('click', function(e) {
                    // Don't trigger if clicking on action button
                    if (!e.target.closest('.action-btn') && !e.target.classList.contains('action-btn')) {
                        const detailLink = this.querySelector('.action-btn');
                        if (detailLink) {
                            window.location.href = detailLink.href;
                        }
                    }
                });
            });
        });
    </script>
@endsection