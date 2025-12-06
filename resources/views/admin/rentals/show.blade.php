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

        /* --- General Buttons & Cards --- */
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

        /* --- Header Styling (Status Card) --- */
        .header-card {
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%);
            border-radius: 0.75rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            color: white;
        }
        .status-badge {
            padding: 1rem 1.75rem;
            border-radius: 50px;
            border: 2px solid rgba(255,255,255,0.3);
            text-align: center;
        }
        .status-badge .icon {
            font-size: 2rem;
            margin-bottom: 0.3rem;
            color: white;
        }
        .status-badge .text {
            font-size: 1.1rem;
            font-weight: 700;
        }

        /* Status Colors (Using Primary/Secondary Only) */
        .status-pending { background: rgba(231, 76, 60, 0.2); } /* Primary Red Accent for Pending background */
        .status-active { background: rgba(44, 62, 80, 0.2); } /* Secondary Dark Accent for Active background */
        .status-completed { background: rgba(44, 62, 80, 0.2); }
        .status-cancelled { background: rgba(231, 76, 60, 0.2); }

        /* --- Tables --- */
        .detail-table td {
            padding: 0.75rem 0;
            font-size: 0.9rem;
        }
        .detail-table tr:not(:last-child) {
            border-bottom: 1px solid var(--color-bg-light);
        }
        .detail-table td:first-child {
            font-weight: 600;
            color: var(--color-text-light);
            width: 45%;
        }
        .detail-table strong {
            color: var(--color-primary);
        }
        .cost-row {
            color: var(--color-primary);
        }
        .total-row {
            background-color: var(--color-bg-light); /* Light Grey Background */
            border-top: 2px solid var(--color-secondary) !important;
        }
        .total-row td {
            font-weight: 700 !important;
            font-size: 1.1rem !important;
            color: var(--color-secondary) !important;
        }

        /* --- Specific Elements --- */
        .notes-box {
            background: #f9fbfd; /* Very light grey */
            border-left: 4px solid var(--color-secondary);
            color: var(--color-secondary);
        }
        .damage-header {
            background: linear-gradient(135deg, var(--color-bg-light) 0%, #f9fbfd 100%);
        }
        .damage-item {
            background: #f9fbfd; /* Lightest Grey for item background */
            border-left: 4px solid var(--color-primary); /* Primary Red border for warning */
            color: var(--color-secondary);
        }
        .damage-cost {
            font-weight: 700;
            color: var(--color-primary);
            font-size: 1.1rem;
        }
        .no-damage-box {
            background: #f9fbfd;
            color: var(--color-secondary);
        }

        /* --- Action Buttons --- */
        .btn-success { background-color: var(--color-secondary); border-color: var(--color-secondary); color: white; }
        .btn-success:hover { background-color: #34495e; }
        .btn-danger { background-color: var(--color-primary); border-color: var(--color-primary); color: white; }
        .btn-danger:hover { background-color: #c0392b; }
        .btn-warning { background-color: var(--color-primary); border-color: var(--color-primary); color: white; }
        .btn-warning:hover { background-color: #c0392b; }

        .form-control { border: 1px solid #ccc; padding: 0.5rem; border-radius: 0.3rem; width: 100%; box-sizing: border-box; }
        #completeForm { background: var(--color-bg-light); border-top: 2px solid var(--color-secondary); }
        #damageForm { background: var(--color-bg-light); border-top: 2px solid var(--color-primary); }
    </style>

    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>
            Kembali ke Daftar
        </a>
    </div>

    <div class="header-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Detail Transaksi</div>
                <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 8px;">#{{ $rental->rental_code }}</h1>
                <div style="font-size: 16px; opacity: 0.95;">Booking: {{ $rental->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
            <div style="text-align: center;">
                @if($rental->status == 'pending')
                    <div class="status-badge status-pending">
                        <div class="icon"><i class="fas fa-clock"></i></div>
                        <div class="text">PENDING</div>
                    </div>
                @elseif($rental->status == 'active')
                    <div class="status-badge status-active">
                        <div class="icon"><i class="fas fa-play-circle"></i></div>
                        <div class="text">AKTIF</div>
                    </div>
                @elseif($rental->status == 'completed')
                    <div class="status-badge status-completed">
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                        <div class="text">SELESAI</div>
                    </div>
                @else
                    <div class="status-badge status-cancelled">
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                        <div class="text">DIBATALKAN</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1.3fr; gap: 24px; margin-bottom: 32px;">

        <div>
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h2><i class="fas fa-info-circle" style="margin-right: 8px; color: var(--color-secondary);"></i> Informasi Transaksi</h2>
                </div>
                <div style="padding: 24px;">
                    <table class="detail-table" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td>Kode Booking</td>
                            <td><strong style="color: var(--color-secondary);">{{ $rental->rental_code }}</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai</td>
                            <td><span style="color: var(--color-secondary); font-weight: 600;">{{ $rental->start_date->format('d/m/Y') }}</span></td>
                        </tr>
                        <tr>
                            <td>Tanggal Selesai</td>
                            <td><span style="color: var(--color-secondary); font-weight: 600;">{{ $rental->end_date->format('d/m/Y') }}</span></td>
                        </tr>
                        @if($rental->actual_return_date)
                        <tr>
                            <td>Tanggal Kembali Aktual</td>
                            <td><span style="color: var(--color-secondary); font-weight: 600;">{{ $rental->actual_return_date->format('d/m/Y H:i') }}</span></td>
                        </tr>
                        @endif
                        <tr>
                            <td>Durasi</td>
                            <td><span style="color: var(--color-secondary); font-weight: 600;">{{ $rental->total_days }} hari</span></td>
                        </tr>
                        <tr>
                            <td>Harga per Hari</td>
                            <td><span style="color: var(--color-secondary); font-weight: 600;">Rp {{ number_format($rental->price_per_day, 0, ',', '.') }}</span></td>
                        </tr>
                    </table>

                    @if($rental->notes)
                    <div class="notes-box" style="margin-top: 20px; padding: 16px; border-radius: 8px;">
                        <div style="font-size: 13px; font-weight: 600; color: var(--color-text-light); margin-bottom: 6px;">CATATAN CUSTOMER:</div>
                        <div style="font-size: 14px;">{{ $rental->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-wallet" style="margin-right: 8px; color: var(--color-secondary);"></i> Rincian Biaya</h2>
                </div>
                <div style="padding: 24px;">
                    @php
                        $basePrice = $rental->total_price - ($rental->penalty_cost ?? 0) - $damageCost;
                    @endphp

                    <table class="detail-table" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="color: var(--color-text-light); width: 60%;">Biaya Sewa ({{ $rental->total_days }} hari)</td>
                            <td style="text-align: right; font-weight: 600; color: var(--color-secondary);">Rp {{ number_format($basePrice, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="cost-row" style="color: var(--color-primary); font-weight: 600;">Biaya Kerusakan</td>
                            <td class="cost-row" style="text-align: right; font-weight: 700;">+ Rp {{ number_format($damageCost, 0, ',', '.') }}</td>
                        </tr>
                        <tr style="border-bottom: 2px solid var(--color-secondary);">
                            <td class="cost-row" style="color: var(--color-primary); font-weight: 600;">Denda Keterlambatan</td>
                            <td class="cost-row" style="text-align: right; font-weight: 700;">+ Rp {{ number_format($rental->penalty_cost ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="total-row">
                            <td style="padding: 16px 0; ">TOTAL TAGIHAN</td>
                            <td style="padding: 16px 0; text-align: right; color: var(--color-primary) !important; font-size: 1.25rem !important;">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    @if(($rental->penalty_cost ?? 0) > 0)
                    <div style="margin-top: 16px; padding: 12px; background: var(--color-bg-light); border-radius: 8px; font-size: 13px; color: var(--color-secondary);">
                        <i class="fas fa-info-circle" style="margin-right: 6px;"></i>
                        Denda keterlambatan dihitung otomatis saat penyelesaian transaksi.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h2><i class="fas fa-user-circle" style="margin-right: 8px; color: var(--color-secondary);"></i> Informasi Customer & Kendaraan</h2>
                </div>
                <div style="padding: 24px;">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--color-secondary); margin-bottom: 1rem; padding-bottom: 12px; border-bottom: 2px solid var(--color-bg-light);">Data Customer</h3>
                    <table style="width: 100%; margin-bottom: 28px;">
                        <tr><td style="padding: 8px 0; font-weight: 600; color: var(--color-text-light); width: 35%;">Nama</td><td style="padding: 8px 0; color: var(--color-secondary);">{{ $rental->user->name }}</td></tr>
                        <tr><td style="padding: 8px 0; font-weight: 600; color: var(--color-text-light);">Telepon</td><td style="padding: 8px 0; color: var(--color-secondary);">{{ $rental->user->phone ?? '-' }}</td></tr>
                        <tr><td style="padding: 8px 0; font-weight: 600; color: var(--color-text-light);">NIK</td><td style="padding: 8px 0; color: var(--color-secondary);">{{ $rental->user->identity_number ?? '-' }}</td></tr>
                        <tr><td style="padding: 8px 0; font-weight: 600; color: var(--color-text-light);">SIM</td><td style="padding: 8px 0; color: var(--color-secondary);">{{ $rental->user->driver_license ?? '-' }}</td></tr>
                    </table>

                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--color-secondary); margin-bottom: 1rem; padding-bottom: 12px; border-bottom: 2px solid var(--color-bg-light);">Data Kendaraan</h3>
                    <table style="width: 100%;">
                        <tr><td style="padding: 8px 0; font-weight: 600; color: var(--color-text-light); width: 35%;">Kendaraan</td><td style="padding: 8px 0; font-weight: 700; color: var(--color-secondary);">{{ $rental->vehicle->brand }} {{ $rental->vehicle->type }}</td></tr>
                        <tr><td style="padding: 8px 0; font-weight: 600; color: var(--color-text-light);">Plat Nomor</td><td style="padding: 8px 0; color: var(--color-secondary);">{{ $rental->vehicle->plate_number }}</td></tr>
                        <tr><td style="padding: 8px 0; font-weight: 600; color: var(--color-text-light);">Kategori</td><td style="padding: 8px 0; color: var(--color-secondary);"><i class="fas fa-{{ $rental->vehicle->category == 'motor' ? 'motorcycle' : 'car' }}" style="margin-right: 6px;"></i> {{ $rental->vehicle->category == 'motor' ? 'Motor' : 'Mobil' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header damage-header">
                    <h2 style="color: var(--color-primary);"><i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> Laporan Kerusakan</h2>
                    <div style="font-weight: 700; color: var(--color-primary); font-size: 1.1rem;">
                        Total: Rp {{ number_format($damageCost, 0, ',', '.') }}
                    </div>
                </div>
                <div style="padding: 24px;">
                    @forelse($rental->damages as $damage)
                    <div class="damage-item" style="padding: 20px; border-radius: 10px; margin-bottom: 16px;">
                        <div style="display: flex; gap: 16px;">
                            <div style="flex: 1;">
                                <h4 style="font-size: 15px; font-weight: 700; color: var(--color-secondary); margin-bottom: 8px;">{{ $damage->description }}</h4>
                                <div style="margin-bottom: 8px;">
                                    <span style="font-size: 13px; color: var(--color-text-light);">Biaya:</span>
                                    <span class="damage-cost">Rp {{ number_format($damage->damage_cost, 0, ',', '.') }}</span>
                                </div>
                                <div style="font-size: 13px; color: var(--color-text-light);">
                                    <i class="fas fa-calendar" style="margin-right: 4px;"></i>
                                    {{ $damage->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            @if($damage->image)
                            <a href="{{ asset('storage/' . $damage->image) }}" target="_blank" style="flex-shrink: 0;">
                                <img src="{{ asset('storage/' . $damage->image) }}" alt="Kerusakan" 
                                        style="width: 120px; height: 90px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid var(--color-primary);">
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="no-damage-box" style="text-align: center; padding: 40px 20px; border-radius: 10px;">
                        <div style="font-size: 48px; opacity: 0.3; margin-bottom: 12px;"><i class="fas fa-check-circle"></i></div>
                        <div style="font-weight: 600; font-size: 15px;">Tidak ada kerusakan yang dilaporkan</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @if($rental->status == 'pending' || $rental->status == 'active')
    <div class="card">
        <div style="padding: 28px 32px; background: var(--color-bg-light);">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--color-secondary); margin-bottom: 20px;">
                <i class="fas fa-bullseye" style="margin-right: 8px;"></i> Aksi Transaksi
            </h3>
            
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                @if($rental->status == 'pending')
                    <form action="{{ route('admin.rentals.approve', $rental) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success" style="padding: 14px 28px; font-size: 15px;" onclick="return confirm('Setujui transaksi ini?')">
                            <i class="fas fa-check-circle" style="margin-right: 6px;"></i>
                            Setujui Transaksi
                        </button>
                    </form>
                    <form action="{{ route('admin.rentals.cancel', $rental) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding: 14px 28px; font-size: 15px;" onclick="return confirm('Batalkan transaksi ini?')">
                            <i class="fas fa-times-circle" style="margin-right: 6px;"></i>
                            Batalkan
                        </button>
                    </form>
                @elseif($rental->status == 'active')
                    <button type="button" class="btn btn-success" style="padding: 14px 28px; font-size: 15px;" 
                            onclick="document.getElementById('completeForm').style.display='block'; document.getElementById('damageForm').style.display='none';">
                        <i class="fas fa-flag-checkered" style="margin-right: 6px;"></i>
                        Selesaikan Transaksi
                    </button>
                    <button type="button" class="btn btn-warning" style="padding: 14px 28px; font-size: 15px;"
                            onclick="document.getElementById('damageForm').style.display='block'; document.getElementById('completeForm').style.display='none';">
                        <i class="fas fa-exclamation-triangle" style="margin-right: 6px;"></i>
                        Tambah Kerusakan
                    </button>
                    <form action="{{ route('admin.rentals.cancel', $rental) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding: 14px 28px; font-size: 15px;" onclick="return confirm('Batalkan paksa transaksi aktif ini?')">
                            <i class="fas fa-ban" style="margin-right: 6px;"></i>
                            Batalkan Paksa
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if($rental->status == 'active')
        <div id="completeForm" style="display: none; padding: 32px;">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--color-secondary); margin-bottom: 20px;"><i class="fas fa-flag-checkered" style="margin-right: 8px;"></i> Selesaikan Transaksi</h3>
            <form action="{{ route('admin.rentals.complete', $rental) }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px; font-size: 14px;">Tanggal Pengembalian Aktual (Opsional)</label>
                    <input type="date" name="actual_return_date" class="form-control" value="{{ date('Y-m-d') }}" style="max-width: 300px;">
                    <small style="color: var(--color-text-light); font-size: 13px; display: block; margin-top: 6px;">
                        <i class="fas fa-info-circle" style="margin-right: 4px;"></i>
                        Denda akan dihitung otomatis berdasarkan waktu penyelesaian.
                    </small>
                </div>
                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-success" style="padding: 12px 24px;" onclick="return confirm('Pastikan semua kerusakan sudah dicatat. Lanjutkan?')">
                        <i class="fas fa-check" style="margin-right: 6px;"></i>
                        Selesaikan & Hitung Biaya Akhir
                    </button>
                    <button type="button" class="btn btn-secondary" style="padding: 12px 24px;" onclick="document.getElementById('completeForm').style.display='none'">Batal</button>
                </div>
            </form>
        </div>

        <div id="damageForm" style="display: none; padding: 32px;">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--color-primary); margin-bottom: 20px;"><i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> Tambah Laporan Kerusakan</h3>
            <form action="{{ route('admin.rentals.damages', $rental) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px; font-size: 14px;">Deskripsi Kerusakan *</label>
                        <textarea name="description" class="form-control" required placeholder="Contoh: Lecet bemper depan, Bensin kurang 5 liter" rows="3"></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px; font-size: 14px;">Biaya Kerusakan (Rp) *</label>
                            <input type="number" name="damage_cost" class="form-control" min="0" step="1000" required placeholder="500000">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px; font-size: 14px;">Foto Bukti (Opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn btn-warning" style="padding: 12px 24px;">
                            <i class="fas fa-save" style="margin-right: 6px;"></i>
                            Simpan Kerusakan
                        </button>
                        <button type="button" class="btn btn-secondary" style="padding: 12px 24px;" onclick="document.getElementById('damageForm').style.display='none'">Batal</button>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
    @endif

@endsection