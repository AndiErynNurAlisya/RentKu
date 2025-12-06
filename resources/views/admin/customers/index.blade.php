@extends('layouts.admin')

@section('content')

    {{-- Custom Styles for this page (Adjusted to be consistent) --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
        }
        
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-top: 1rem;
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
        .card-header .total-info {
            font-size: 0.9rem;
            color: var(--color-text-light);
        }
        .card-header .total-info strong {
            color: var(--color-primary); /* Use Primary Red for emphasis */
            font-weight: 700;
        }

        /* --- Table Styling --- */
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
        .card tbody tr:hover {
            background-color: #fcfcfc;
        }
        
        /* Badge for Total Transactions */
        .badge {
            padding: 0.4em 0.8em;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            font-size: 0.8rem;
        }
        .badge-info { 
            background-color: #f4d0d0; /* Light Red */
            color: var(--color-primary); /* Primary Red Text */
            font-weight: 700;
        }

        /* Detail Button */
        .btn-primary {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.85rem;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #34495e; /* Slightly darker secondary color */
        }
        
        /* Empty State */
        .empty-state-icon {
            font-size: 3rem; 
            opacity: 0.25; 
            margin-bottom: 1rem;
            color: var(--color-text-light);
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-users" style="margin-right: 8px; color: var(--color-secondary);"></i> Daftar Pelanggan</h2>
            <div class="total-info">
                Total: <strong style="color: var(--color-primary);">{{ $customers->total() }}</strong> pelanggan
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Kontak</th>
                        <th>Identitas</th>
                        <th>Total Transaksi</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: var(--color-secondary); font-size: 15px;">{{ $customer->name }}</div>
                        </td>
                        <td>
                            <div style="margin-bottom: 4px; font-size: 14px; color: var(--color-secondary);">
                                <i class="fas fa-envelope" style="margin-right: 6px; color: var(--color-text-light);"></i>
                                {{ $customer->email }}
                            </div>
                            <div style="font-size: 14px; color: var(--color-secondary);">
                                <i class="fas fa-phone" style="margin-right: 6px; color: var(--color-text-light);"></i>
                                {{ $customer->phone ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div style="margin-bottom: 4px; font-size: 13px; color: var(--color-secondary);">
                                <span style="color: var(--color-text-light);">NIK:</span> {{ $customer->identity_number ?? '-' }}
                            </div>
                            <div style="font-size: 13px; color: var(--color-secondary);">
                                <span style="color: var(--color-text-light);">SIM:</span> {{ $customer->driver_license ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info" style="font-size: 14px; padding: 8px 16px;">
                                <i class="fas fa-clipboard-list" style="margin-right: 4px;"></i>
                                {{ $customer->rentals_count }} transaksi
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 14px; color: var(--color-secondary);">{{ $customer->created_at->format('d/m/Y') }}</div>
                            <div style="font-size: 13px; color: var(--color-text-light);">{{ $customer->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye" style="margin-right: 4px;"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px;">
                            <div class="empty-state-icon">
                                <i class="fas fa-user-slash"></i> {{-- Icon untuk 'belum ada pelanggan' --}}
                            </div>
                            <h3 style="font-size: 18px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">Belum Ada Pelanggan</h3>
                            <p style="color: var(--color-text-light); font-size: 14px; margin: 0;">Data pelanggan akan muncul di sini setelah ada pendaftaran.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
        <div style="padding: 24px 32px; border-top: 1px solid var(--color-bg-light);">
            {{ $customers->links() }}
        </div>
        @endif
    </div>

@endsection