@extends('layouts.admin')

@section('content')

    {{-- Custom Styles for this page --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
        }
        
        .btn-secondary {
            background-color: var(--color-bg-light);
            color: var(--color-secondary);
            border: 1px solid var(--color-bg-light);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }
        .btn-secondary:hover {
            background-color: #d8dbe0;
        }

        /* --- Header Styling --- */
        .customer-header {
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%); /* Using dark tones */
            border-radius: 0.75rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            color: white;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .customer-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            border: 3px solid rgba(255,255,255,0.3);
        }
        .customer-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* --- Card & Table Styling --- */
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--color-bg-light);
        }
        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-secondary);
            margin: 0;
        }
        .info-table td {
            padding: 0.75rem 0;
            font-size: 0.9rem;
        }
        .info-table tr:not(:last-child) {
            border-bottom: 1px solid var(--color-bg-light);
        }
        .info-table td:first-child {
            font-weight: 600;
            color: var(--color-text-light);
            width: 30%;
        }
        .info-table td:last-child {
            color: var(--color-secondary);
            font-weight: 500;
        }
        
        /* --- Stat Card Styling --- */
        .stat-card {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }
        .stat-value-large {
            font-size: 3rem;
            font-weight: 800;
        }

        /* --- Transaction Table Styling --- */
        .table-responsive table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-responsive th, .table-responsive td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--color-bg-light);
            font-size: 0.9rem;
        }
        .table-responsive th {
            color: var(--color-secondary);
            background-color: #f9fbfd;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Badge Styling (Consistent with previous response) */
        .badge {
            padding: 0.4em 0.8em;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            font-size: 0.8rem;
            text-transform: capitalize;
        }
        .badge-warning { background-color: #f4d0d0; color: var(--color-primary); }
        .badge-info { background-color: #f9fbfd; color: var(--color-secondary); border: 1px solid var(--color-bg-light); }
        .badge-success { background-color: #f4d0d0; color: var(--color-secondary); }
        .badge-danger { background-color: var(--color-primary); color: #ffffff; }

        /* Detail/Aksi Button */
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.85rem;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #c0392b;
        }
    </style>

<div style="margin-bottom: 24px; text-align: right;">
    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>
        Kembali ke Daftar
    </a>
</div>

    <div class="customer-header">
        <div class="customer-icon-wrapper">
            <i class="fas fa-user-circle"></i> {{-- Icon: User Circle --}}
        </div>
        <div style="flex: 1;">
            <h1 style="color: white;">{{ $customer->name }}</h1>
            <div style="font-size: 16px; opacity: 0.95;">{{ $customer->email }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 32px;">

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-info-circle" style="margin-right: 8px; color: var(--color-secondary);"></i> Informasi Pribadi</h2>
            </div>
            <div style="padding: 24px;">
                <table class="info-table" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>Nama</td>
                        <td><strong style="color: var(--color-secondary);">{{ $customer->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $customer->email }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{ $customer->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>{{ $customer->identity_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>SIM</td>
                        <td>{{ $customer->driver_license ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Terdaftar</td>
                        <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div>
            {{-- Total Transaksi --}}
            <div class="stat-card" style="margin-bottom: 20px; border-top: 4px solid var(--color-secondary);">
                <div style="text-align: center;">
                    <div class="stat-icon" style="color: var(--color-secondary);"><i class="fas fa-receipt"></i></div> {{-- Icon: Receipt --}}
                    <h3 style="font-size: 0.9rem; color: var(--color-text-light); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Total Transaksi</h3>
                    <div class="stat-value-large" style="color: var(--color-secondary);">{{ $customer->rentals->count() }}</div>
                </div>
            </div>

            {{-- Transaksi Aktif --}}
            <div class="stat-card" style="border-top: 4px solid var(--color-primary);">
                <div style="text-align: center;">
                    <div class="stat-icon" style="color: var(--color-primary);"><i class="fas fa-clock"></i></div> {{-- Icon: Clock --}}
                    <h3 style="font-size: 0.9rem; color: var(--color-text-light); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Transaksi Aktif</h3>
                    <div class="stat-value-large" style="color: var(--color-primary);">{{ $customer->rentals->where('status', 'active')->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-history" style="margin-right: 8px; color: var(--color-secondary);"></i> Riwayat Transaksi</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Kendaraan</th>
                        <th>Tanggal Sewa</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customer->rentals as $rental)
                    <tr>
                        <td><strong style="color: var(--color-secondary);">{{ $rental->rental_code }}</strong></td>
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
                                    <i class="fas fa-hourglass-half" style="margin-right: 4px;"></i>Pending
                                </span>
                            @elseif($rental->status == 'active')
                                <span class="badge badge-info">
                                    <i class="fas fa-car" style="margin-right: 4px;"></i>Aktif
                                </span>
                            @elseif($rental->status == 'completed')
                                <span class="badge badge-success">
                                    <i class="fas fa-check" style="margin-right: 4px;"></i>Selesai
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times" style="margin-right: 4px;"></i>Dibatalkan
                                </span>
                            @endif
                        </td>
                        <td><strong style="color: var(--color-primary);">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong></td>
                        <td>
                            <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye" style="margin-right: 4px;"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px 20px;">
                            <div style="font-size: 48px; opacity: 0.2; margin-bottom: 12px; color: var(--color-text-light);"><i class="fas fa-box-open"></i></div>
                            <div style="color: var(--color-text-light); font-size: 15px;">Pelanggan ini belum memiliki riwayat transaksi.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection