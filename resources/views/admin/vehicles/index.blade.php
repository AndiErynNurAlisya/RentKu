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
        }

        /* Container Styles */
        .vehicles-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-top: 1.5rem;
        }

        /* Header Styles */
        .vehicles-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
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

        .btn-add {
            background: linear-gradient(135deg, var(--color-primary) 0%, #c0392b 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(231, 76, 60, 0.2);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 10px -1px rgba(231, 76, 60, 0.3);
        }

        /* Table Styles */
        .vehicles-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .vehicles-table thead {
            background: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .vehicles-table th {
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--color-secondary);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .vehicles-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .vehicles-table tbody tr:hover {
            background: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .vehicles-table td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            color: #475569;
        }

        /* Image Cell */
        .vehicle-image {
            width: 80px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .vehicle-image:hover {
            transform: scale(1.05);
        }

        .image-placeholder {
            width: 80px;
            height: 60px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Vehicle Info */
        .vehicle-brand {
            font-weight: 700;
            color: #0f172a;
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .vehicle-type {
            color: #64748b;
            font-size: 0.875rem;
        }

        /* Plate Number */
        .plate-number {
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--color-secondary);
            border: 1px dashed #cbd5e1;
            display: inline-block;
        }

        /* Category Badge */
        .category-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .category-car {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .category-motor {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #0369a1;
        }

        /* Price */
        .price-container {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .price-amount {
            font-weight: 700;
            color: #1e40af;
            font-size: 1rem;
        }

        .price-period {
            font-size: 0.75rem;
            color: #64748b;
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

        .status-available {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .status-rented {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .status-maintenance {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #fde68a 0%, #fcd34d 100%);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(251, 191, 36, 0.2);
        }

        .btn-delete {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
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
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: center;
            background: #ffffff;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .vehicles-table {
                display: block;
                overflow-x: auto;
            }
            
            .action-buttons {
                min-width: 160px;
            }
        }

        @media (max-width: 768px) {
            .vehicles-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .header-title {
                justify-content: center;
            }
            
            .vehicles-table th,
            .vehicles-table td {
                padding: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 6px;
            }
            
            .btn-action {
                justify-content: center;
            }
        }
    </style>

    <div class="vehicles-container">
        <!-- Header -->
        <div class="vehicles-header">
            <div class="header-title">
                <i class="fas fa-car"></i>
                <h2>Daftar Kendaraan</h2>
            </div>
            <a href="{{ route('admin.vehicles.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Tambah Kendaraan
            </a>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="vehicles-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Kendaraan</th>
                        <th>Plat Nomor</th>
                        <th>Kategori</th>
                        <th>Harga/Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <!-- Foto -->
                        <td>
                            @if($vehicle->image)
                                <img src="{{ asset('storage/' . $vehicle->image) }}" 
                                     alt="{{ $vehicle->brand }}" 
                                     class="vehicle-image">
                            @else
                                <div class="image-placeholder">
                                    {{ $vehicle->category == 'motor' ? '🏍️' : '🚗' }}
                                </div>
                            @endif
                        </td>
                        
                        <!-- Info Kendaraan -->
                        <td>
                            <div class="vehicle-brand">{{ $vehicle->brand }}</div>
                            <div class="vehicle-type">{{ $vehicle->type }}</div>
                        </td>
                        
                        <!-- Plat Nomor -->
                        <td>
                            <span class="plate-number">{{ $vehicle->plate_number }}</span>
                        </td>
                        
                        <!-- Kategori -->
                        <td>
                            <span class="category-badge {{ $vehicle->category == 'motor' ? 'category-motor' : 'category-car' }}">
                                {{ $vehicle->category == 'motor' ? '🏍️ Motor' : '🚗 Mobil' }}
                            </span>
                        </td>
                        
                        <!-- Harga -->
                        <td>
                            <div class="price-container">
                                <span class="price-amount">
                                    Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                </span>
                                <span class="price-period">/hari</span>
                            </div>
                        </td>
                        
                        <!-- Status -->
                        <td>
                            @if($vehicle->status == 'tersedia')
                                <span class="status-badge status-available">
                                    <i class="fas fa-check-circle"></i>
                                    Tersedia
                                </span>
                            @elseif($vehicle->status == 'dipinjam')
                                <span class="status-badge status-rented">
                                    <i class="fas fa-clock"></i>
                                    Disewa
                                </span>
                            @else
                                <span class="status-badge status-maintenance">
                                    <i class="fas fa-wrench"></i>
                                    Maintenance
                                </span>
                            @endif
                        </td>
                        
                        <!-- Aksi -->
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                                   class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                
                                <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                                <h3 class="empty-title">Belum Ada Kendaraan</h3>
                                <p class="empty-subtitle">Mulai dengan menambahkan kendaraan pertama Anda untuk memulai penyewaan.</p>
                                <a href="{{ route('admin.vehicles.create') }}" class="btn-add">
                                    <i class="fas fa-plus"></i>
                                    Tambah Kendaraan Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($vehicles->hasPages())
        <div class="pagination-container">
            {{ $vehicles->links() }}
        </div>
        @endif
    </div>

    <!-- Optional: Add some JavaScript for interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects
            const tableRows = document.querySelectorAll('.vehicles-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.cursor = 'pointer';
                });
                
                row.addEventListener('click', function(e) {
                    // Don't trigger if clicking on action buttons
                    if (!e.target.closest('.action-buttons') && 
                        !e.target.closest('form') && 
                        !e.target.closest('.btn-action')) {
                        // Optional: Add click to view detail functionality
                        // window.location.href = '/admin/vehicles/' + vehicleId;
                    }
                });
            });
        });
    </script>
@endsection